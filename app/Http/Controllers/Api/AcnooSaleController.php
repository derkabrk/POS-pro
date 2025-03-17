<?php

namespace App\Http\Controllers\Api;

use App\Models\Sale;
use App\Models\Party;
use App\Models\Product;
use App\Models\Business;
use App\Models\SaleDetails;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AcnooSaleController extends Controller
{
    use HasUploader;

    public function index()
    {
        $data = Sale::with('user:id,name', 'party:id,name,email,phone,type', 'details', 'details.product:id,productName,category_id,productCode,productPurchasePrice,productStock', 'details.product.category:id,categoryName', 'saleReturns.details', 'vat:id,name,rate', 'payment_type:id,name')
                ->when(request('returned-sales') == "true", function ($query) {
                    $query->whereHas('saleReturns');
                })
                ->where('business_id', auth()->user()->business_id)
                ->latest()
                ->get();

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required',
            'party_id' => 'nullable|exists:parties,id',
            'vat_id' => 'nullable|exists:vats,id',
            'saleDate' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $request_products = json_decode($request->products, true);

        $productIds = collect($request_products)->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $productIds)
                    ->orderByRaw('FIELD(id, ' . implode(',', $productIds) . ')')
                    ->get();

        foreach ($products as $key => $product) {
            if ($product->productStock < $request_products[$key]['quantities']) {
                return response()->json([
                    'message' => __($product->productName . ' - stock not available for this product. Available quantity is: ' . $product->productStock)
                ], 400);
            }
        }

        if ($request->party_id) {
            $party = Party::findOrFail($request->party_id);
        }

        if ($request->dueAmount) {
            if (!$request->party_id) {
                return response()->json([
                    'message' => __('You cannot sell on credit to a walk-in customer.')
                ], 400);
            }

            $party->update([
                'due' => $party->due + $request->dueAmount
            ]);
        }

        $business = Business::findOrFail(auth()->user()->business_id);
        $business_name = $business->companyName;
        $business->update([
            'remainingShopBalance' => $business->remainingShopBalance + $request->paidAmount
        ]);

        $lossProfit = collect($request_products)->pluck('lossProfit')->toArray();

        $sale = Sale::create($request->except('image', 'isPaid') + [
                    'user_id' => auth()->id(),
                    'business_id' => auth()->user()->business_id,
                    'isPaid' => filter_var($request->isPaid, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                    'lossProfit' => array_sum($lossProfit) - $request->discountAmount,
                    'image' => $request->image ? $this->upload($request, 'image') : null,
                    'meta' => [
                        'customer_phone' => $request->customer_phone,
                        'note' => $request->note,
                    ],
                ]);

        $saleDetails = [];
        foreach ($request_products as $key => $productData) {
            $saleDetails[$key] = [
                'sale_id' => $sale->id,
                'price' => $productData['price'],
                'product_id' => $productData['product_id'],
                'lossProfit' => $productData['lossProfit'],
                'quantities' => $productData['quantities'] ?? 0,
            ];

            Product::findOrFail($productData['product_id'])->decrement('productStock', $productData['quantities']);
        }

        SaleDetails::insert($saleDetails);

        if ($party ?? false && $party->phone) {
            if (env('MESSAGE_ENABLED')) {
                sendMessage($party->phone, saleMessage($sale, $party, $business_name));
            }
        }

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $sale->load('user:id,name', 'party:id,name,email,phone,type', 'details', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName', 'saleReturns.details', 'vat:id,name,rate', 'payment_type:id,name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'products' => 'required',
            'party_id' => 'nullable|exists:parties,id',
            'vat_id' => 'nullable|exists:vats,id',
            'saleDate' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $sale = Sale::findOrFail($id);

        DB::beginTransaction();
        try {

            if ($sale->load('saleReturns')->saleReturns->count() > 0) {
                return response()->json([
                    'message' => __("You can not update this sale because it has already been returned.")
                ], 400);
            }

            $request_products = json_decode($request->products, true);
            $prevDetails = SaleDetails::where('sale_id', $sale->id)->get();
            $productIds = collect($request_products)->pluck('product_id')->toArray();
            $products = Product::whereIn('id', $productIds)->get();

            foreach ($products as $key => $product) {
                $prevProduct = $prevDetails->first(function ($item) use($product) {
                    return $item->product_id == $product->id;
                });

                $product_stock = $prevProduct ? ($product->productStock + $prevProduct->quantities) : $product->productStock;
                if ($product_stock < $request_products[$key]['quantities']) {
                    return response()->json([
                        'message' => __($product->productName . ' - stock not available for this product. Available quantity is : '. $product->productStock)
                    ], 400);
                }
            }

            foreach ($prevDetails as $prevItem) {
                Product::findOrFail($prevItem->product_id)->increment('productStock', $prevItem->quantities);
            }

            $prevDetails->each->delete();

            $saleDetails = [];
            foreach ($request_products as $key => $productData) {
                $saleDetails[$key] = [
                    'sale_id' => $sale->id,
                    'price' => $productData['price'],
                    'product_id' => $productData['product_id'],
                    'lossProfit' => $productData['lossProfit'],
                    'quantities' => $productData['quantities'] ?? 0,
                ];

                Product::findOrFail($productData['product_id'])->decrement('productStock', $productData['quantities']);
            }

            SaleDetails::insert($saleDetails);

            if ($sale->dueAmount || $request->dueAmount) {
                $party = Party::findOrFail($request->party_id);
                $party->update([
                    'due' => $request->party_id == $sale->party_id ? (($party->due - $sale->dueAmount) + $request->dueAmount) : ($party->due + $request->dueAmount)
                ]);

                if ($request->party_id != $sale->party_id) {
                    $prev_party = Party::findOrFail($sale->party_id);
                    $prev_party->update([
                        'due' => $prev_party->due - $sale->dueAmount
                    ]);
                }
            }

            $business = Business::findOrFail(auth()->user()->business_id);
            $business->update([
                'shopOpeningBalance' => ($business->shopOpeningBalance - $sale->paidAmount) + $request->paidAmount
            ]);

            $lossProfit = collect($request_products)->pluck('lossProfit')->toArray();

            $sale->update($request->except('image', 'isPaid') + [
                'user_id' => auth()->id(),
                'isPaid' => filter_var($request->isPaid, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'lossProfit' => array_sum($lossProfit) - $request->discountAmount,
                'image' => $request->image ? $this->upload($request, 'image', $sale->image) : $sale->image,
                'meta' => [
                    'customer_phone' => $request->customer_phone,
                    'note' => $request->note,
                ],
            ]);

            DB::commit();
            return response()->json([
                'message' => __('Data saved successfully.'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Sale Update Error: " . $e->getMessage());
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        foreach ($sale->details as $product) {
            Product::findOrFail($product->id)->increment('productStock', $product->quantities);
        }

        if ($sale->dueAmount) {
            $party = Party::findOrFail($sale->party_id);
            $party->update([
                'due' => $party->due - $sale->dueAmount
            ]);
        }

        $business = Business::findOrFail(auth()->user()->business_id);
        $business->update([
            'shopOpeningBalance' => $business->shopOpeningBalance - $sale->paidAmount
        ]);

        if (file_exists($sale->image)) {
            Storage::delete($sale->image);
        }
        $sale->delete();

        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}
