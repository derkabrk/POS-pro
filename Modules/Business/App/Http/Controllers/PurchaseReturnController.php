<?php

namespace Modules\Business\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Party;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['user:id,name', 'party:id,name,email,phone,type', 'details:id,purchase_id,product_id,productPurchasePrice,quantities', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName', 'purchaseReturns' => function ($query) {
                                $query->withSum('details as total_return_amount', 'return_amount');
                            }
                        ])
                        ->where('business_id', auth()->user()->business_id)
                        ->whereHas('purchaseReturns')
                        ->latest()
                        ->paginate(20);

        return view('business::purchase-returns.index',compact('purchases'));
    }


    public function acnooFilter(Request $request)
    {
        $purchases = Purchase::with(['user:id,name', 'party:id,name,email,phone,type', 'details:id,purchase_id,product_id,productPurchasePrice,quantities', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName', 'purchaseReturns' => function ($query) {
                                        $query->withSum('details as total_return_amount', 'return_amount');
                                        }
                                    ])
                                ->where('business_id', auth()->user()->business_id)
                                ->whereHas('purchaseReturns')
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
                'data' => view('business::purchase-returns.datas',compact('purchases'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function create(Request $request)
    {
        $purchase = Purchase::with('details','party','details.product','details.product.unit:id,unitName')
            ->where('business_id', auth()->user()->business_id)
            ->findOrFail($request->purchase_id);

        // Calculate the discount per unit factor
        $total_purchase_price = $purchase->details->sum(fn($detail) => $detail->productPurchasePrice * $detail->quantities);
        $discount_per_unit_factor = $total_purchase_price > 0 ? $purchase->discountAmount / $total_purchase_price : 0;

        return view('business::purchase-returns.create', compact('purchase', 'discount_per_unit_factor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'return_qty' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $purchase = Purchase::with('details')
                ->where('business_id', auth()->user()->business_id)
                ->findOrFail($request->purchase_id);

            // Calculate total discount factor
            $total_discount = $purchase->discountAmount;
            $total_purchase_amount = $purchase->details->sum(fn($detail) => $detail->productPurchasePrice * $detail->quantities);
            $discount_per_unit_factor = $total_purchase_amount > 0 ? $total_discount / $total_purchase_amount : 0;

            $purchase_return = PurchaseReturn::create([
                'business_id' => auth()->user()->business_id,
                'purchase_id' => $request->purchase_id,
                'invoice_no' => $purchase->invoiceNumber,
                'return_date' => now(),
            ]);

            $purchase_return_detail_data = [];
            $total_return_amount = 0;
            $total_return_discount = 0;

            // Loop through each purchase detail and process the return
            foreach ($purchase->details as $key => $detail) {
                $requested_qty = $request->return_qty[$key];

                if ($requested_qty <= 0) {
                    continue;
                }

                // Check if return quantity exceeds the purchased quantity
                if ($requested_qty > $detail->quantities) {
                    return response()->json([
                        'message' => "You can't return more than the ordered quantity of {$detail->quantities}.",
                    ], 400);
                }

                // Calculate per-unit discount and return amounts
                $unit_discount = $detail->productPurchasePrice * $discount_per_unit_factor;
                $return_discount = $unit_discount * $requested_qty;
                $return_amount = ($detail->productPurchasePrice - $unit_discount) * $requested_qty;

                $total_return_amount += $return_amount;
                $total_return_discount += $return_discount;

                // Update stock & purchase details
                Product::findOrFail($detail->product_id)->decrement('productStock', $requested_qty);
                $detail->quantities -= $requested_qty;
                $detail->timestamps = false;
                $detail->save();

                // Collect return detail data
                $purchase_return_detail_data[] = [
                    'purchase_detail_id' => $detail->id,
                    'purchase_return_id' => $purchase_return->id,
                    'return_qty' => $requested_qty,
                    'business_id' => auth()->user()->business_id,
                    'return_amount' => $return_amount,
                ];
            }

            // Insert purchase return details
            if (!empty($purchase_return_detail_data)) {
                PurchaseReturnDetail::insert($purchase_return_detail_data);
            }

            if ($total_return_amount <= 0) {
                return response()->json("You cannot return an empty product.", 400);
            }

            // Update party dues (if applicable)
            $party = Party::find($purchase->party_id);
            if ($party) {
                $party->update([
                    'due' => $party->due > $total_return_amount ? $party->due - $total_return_amount : 0,
                ]);
            }

            // Calculate remaining return amount
            $remaining_return_amount = max(0, $total_return_amount - $purchase->dueAmount);
            $new_total_amount = max(0, $purchase->totalAmount - $total_return_amount);

            // Update purchase record
            $purchase->update([
                'dueAmount' => max(0, $purchase->dueAmount - $total_return_amount),
                'paidAmount' => $total_return_amount > 0 ? $new_total_amount : $purchase->paidAmount,
                'totalAmount' => $new_total_amount,
                'discountAmount' => max(0, $purchase->discountAmount - $total_return_discount),
                'isPaid' => $remaining_return_amount > 0 ? 1 : $purchase->isPaid,
            ]);

            DB::commit();

            return response()->json([
                'message' => __('Purchase returned successfully.'),
                'redirect' => route('business.purchase-returns.index'),
                'secondary_redirect_url' => route('business.purchases.invoice', $purchase->id),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 500);
        }
    }

}

