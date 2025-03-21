<?php

namespace Modules\Business\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Party;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleReturnController extends Controller
{
    public function index()
    {
        $sales =  Sale::with(['user:id,name', 'party:id,name', 'details', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName',
                            'saleReturns' => function($query) {
                                $query->withSum('details as total_return_amount', 'return_amount');
                            }
                        ])
                        ->where('business_id', auth()->user()->business_id)
                        ->whereHas('saleReturns')
                        ->latest()
                        ->paginate(20);

        return view('business::sale-returns.index', compact('sales'));
    }

    public function acnooFilter(Request $request)
    {
        $sales =  Sale::with(['user:id,name', 'party:id,name', 'details', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName',
                                'saleReturns' => function($query) {
                                    $query->withSum('details as total_return_amount', 'return_amount');
                                }
                            ])
                        ->where('business_id', auth()->user()->business_id)
                        ->whereHas('saleReturns')
                        ->when(request('search'), function($q) use($request) {
                            $q->where(function($q) use($request) {
                                $q->where('invoiceNumber', 'like', '%'.$request->search.'%')
                                ->orWhereHas('party', function ($q) use ($request) {
                                    $q->where('name', 'like', '%' . $request->search . '%');
                                });
                            });
                        })
                        ->latest()
                        ->paginate($request->per_page ?? 10);

        if($request->ajax()){
            return response()->json([
                'data' => view('business::sale-returns.datas',compact('sales'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function create(Request $request)
    {
        $sale = Sale::with('details','party','details.product','details.product.unit:id,unitName')
            ->where('business_id', auth()->user()->business_id)
            ->findOrFail($request->sale_id);

        // Calculate the discount per unit factor
        $total_sale_price = $sale->details->sum(fn($detail) => $detail->price * $detail->quantities);
        $discount_per_unit_factor = $total_sale_price > 0 ? $sale->discountAmount / $total_sale_price : 0;

        return view('business::sale-returns.create', compact('sale', 'discount_per_unit_factor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'return_qty' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $sale = Sale::with('details')
                ->where('business_id', auth()->user()->business_id)
                ->findOrFail($request->sale_id);

            // Calculate total discount factor
            $total_discount = $sale->discountAmount;
            $total_sale_amount = $sale->details->sum(fn($detail) => $detail->price * $detail->quantities);
            $discount_per_unit_factor = $total_sale_amount > 0 ? $total_discount / $total_sale_amount : 0;

            $sale_return = SaleReturn::create([
                'business_id' => auth()->user()->business_id,
                'sale_id' => $request->sale_id,
                'invoice_no' => $sale->invoiceNumber,
                'return_date' => now(),
            ]);

            $sale_return_detail_data = [];
            $total_return_amount = 0;
            $total_return_discount = 0;
            $total_loss_profit_adjustment = 0;

            foreach ($sale->details as $key => $detail) {
                $requested_qty = $request->return_qty[$key];

                if ($requested_qty <= 0) {
                    continue;
                }

                if ($requested_qty > $detail->quantities) {
                    return response()->json([
                        'message' => "You can't return more than ordered quantity of {$detail->quantities}.",
                    ], 400);
                }

                // Calculate per-unit discount and return amounts
                $unit_discount = $detail->price * $discount_per_unit_factor;
                $return_discount = $unit_discount * $requested_qty;
                $return_amount = ($detail->price - $unit_discount) * $requested_qty;

                $total_return_amount += $return_amount;
                $total_return_discount += $return_discount;

                // Loss-profit adjustment
                $loss_profit_adjustment = (($detail->price - $detail->product->productPurchasePrice) * $requested_qty) - $return_discount;
                $total_loss_profit_adjustment += $loss_profit_adjustment;

                // Update stock & sale details
                Product::findOrFail($detail->product_id)->increment('productStock', $requested_qty);
                $detail->quantities -= $requested_qty;
                $detail->lossProfit -= $loss_profit_adjustment;
                $detail->timestamps = false;
                $detail->save();

                $sale_return_detail_data[] = [
                    'sale_detail_id' => $detail->id,
                    'sale_return_id' => $sale_return->id,
                    'return_qty' => $requested_qty,
                    'business_id' => auth()->user()->business_id,
                    'return_amount' => $return_amount,
                ];
            }


            if (!empty($sale_return_detail_data)) {
                SaleReturnDetails::insert($sale_return_detail_data);
            }

            if ($total_return_amount <= 0) {
                return response()->json("You cannot return an empty product.", 400);
            }

            $remaining_return_amount = max(0, $total_return_amount - $sale->dueAmount);
            $totalAmount = max(0, $sale->totalAmount - $total_return_amount);

            // Update sale record
            $sale->update([
                'dueAmount' => max(0, $sale->dueAmount - $total_return_amount),
                'paidAmount' => max(0, $sale->paidAmount - min($sale->paidAmount, $total_return_amount)),
                'totalAmount' => $totalAmount,
                'discountAmount' => max(0, $sale->discountAmount - $total_return_discount),
                'lossProfit' => $sale->lossProfit - $total_loss_profit_adjustment,
                'isPaid' => $remaining_return_amount > 0 ? 1 : $sale->isPaid,
            ]);

            // Update party dues (if applicable)
            $party = Party::find($sale->party_id);
            if ($party) {
                $party->update([
                    'due' => $party->due > $total_return_amount ? $party->due - $total_return_amount : 0,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => __('Sale returned successfully.'),
                'redirect' => route('business.sale-returns.index'),
                'secondary_redirect_url' => route('business.sales.invoice', $sale->id),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 500);
        }
    }

}
