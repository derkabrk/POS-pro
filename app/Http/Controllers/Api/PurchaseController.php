<?php

namespace App\Http\Controllers\Api;

use App\Models\Party;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\PurchaseDetails;
use App\Http\Controllers\Controller;
use App\Models\Business;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Purchase::with('user:id,name', 'party:id,name,email,phone,type', 'details:id,purchase_id,product_id,productPurchasePrice,quantities', 'details.product:id,productName,category_id,productPurchasePrice,productDealerPrice,productSalePrice,productWholeSalePrice,productStock', 'details.product.category:id,categoryName', 'purchaseReturns.details', 'vat:id,name,rate', 'payment_type:id,name')
                ->when(request('returned-purchase') == "true", function ($query) {
                    $query->whereHas('purchaseReturns');
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
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'party_id' => 'required|exists:parties,id'
        ]);

        if ($request->dueAmount) {
            $party = Party::findOrFail($request->party_id);
            $party->update([
                'due' => $party->due + $request->dueAmount
            ]);
        }

        $business = Business::findOrFail(auth()->user()->business_id);
        $business->update([
            'remainingShopBalance' => $business->remainingShopBalance - $request->paidAmount
        ]);

        $purchase = Purchase::create($request->all() + [
                        'user_id' => auth()->id(),
                        'business_id' => auth()->user()->business_id,
                    ]);

        $purchaseDetails = [];
        foreach ($request->products as $key => $product_data) {
            $purchaseDetails[$key] = [
                'purchase_id' => $purchase->id,
                'product_id' => $product_data['product_id'],
                'quantities' => $product_data['quantities'] ?? 0,
                'productSalePrice' => $product_data['productSalePrice'] ?? 0,
                'productDealerPrice' => $product_data['productDealerPrice'] ?? 0,
                'productPurchasePrice' => $product_data['productPurchasePrice'] ?? 0,
                'productWholeSalePrice' => $product_data['productWholeSalePrice'] ?? 0,
            ];
        }

        PurchaseDetails::insert($purchaseDetails);

        foreach ($purchaseDetails as $item) {
            $product = Product::findOrFail($item['product_id']);
            $product->update([
                'productStock' => $product->productStock + (int) $item['quantities'] ?? 0,
                'productSalePrice' => $item['productSalePrice'] ?? $product->productSalePrice,
                'productDealerPrice' => $item['productDealerPrice'] ?? $product->productDealerPrice,
                'productPurchasePrice' => $item['productPurchasePrice'] ?? $product->productPurchasePrice,
                'productWholeSalePrice' => $item['productWholeSalePrice'] ?? $product->productWholeSalePrice,
                'meta' => [
                    'productSalePrice' => $product->productSalePrice,
                    'productDealerPrice' => $product->productDealerPrice,
                    'productPurchasePrice' => $product->productPurchasePrice,
                    'productWholeSalePrice' => $product->productWholeSalePrice,
                ]
            ]);
        }

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $purchase->load('user:id,name', 'party:id,name,email,phone,type', 'details:id,purchase_id,product_id,productPurchasePrice,quantities', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName', 'purchaseReturns.details', 'vat:id,name,rate', 'payment_type:id,name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'party_id' => 'required|exists:parties,id'
        ]);

        if ($purchase->load('purchaseReturns')->purchaseReturns->count() > 0) {
            return response()->json([
                'message' => __("You can not update this purchase because it has already been returned.")
            ], 400);
        }

        $prevDetails = PurchaseDetails::where('purchase_id', $purchase->id)->get();
        foreach ($prevDetails as $prevProduct) {
            $updateProduct = Product::findOrFail($prevProduct->product_id);
            $updateProduct->update([
                'productStock' => $updateProduct->productStock - (int) $prevProduct->quantities,
                'productSalePrice' => $updateProduct->meta['productSalePrice'] ?? $prevProduct->productSalePrice,
                'productDealerPrice' => $updateProduct->meta['productDealerPrice'] ?? $prevProduct->productDealerPrice,
                'productPurchasePrice' => $updateProduct->meta['productPurchasePrice'] ?? $prevProduct->productPurchasePrice,
                'productWholeSalePrice' => $updateProduct->meta['productWholeSalePrice'] ?? $prevProduct->productWholeSalePrice,
            ]);
        }
        $prevDetails->each->delete();

        $purchaseDetails = [];
        foreach ($request->products as $key => $product_data) {
            $purchaseDetails[$key] = [
                'purchase_id' => $purchase->id,
                'product_id' => $product_data['product_id'],
                'quantities' => $product_data['quantities'] ?? 0,
                'productSalePrice' => $product_data['productSalePrice'] ?? 0,
                'productDealerPrice' => $product_data['productDealerPrice'] ?? 0,
                'productPurchasePrice' => $product_data['productPurchasePrice'] ?? 0,
                'productWholeSalePrice' => $product_data['productWholeSalePrice'] ?? 0,
            ];
        }

        PurchaseDetails::insert($purchaseDetails);

        foreach ($purchaseDetails as $item) {
            $product = Product::findOrFail($item['product_id']);
            $product->update([
                'productStock' => $product->productStock + (int) $item['quantities'] ?? 0,
                'productSalePrice' => $item['productSalePrice'] ?? $product->productSalePrice,
                'productDealerPrice' => $item['productDealerPrice'] ?? $product->productDealerPrice,
                'productPurchasePrice' => $item['productPurchasePrice'] ?? $product->productPurchasePrice,
                'productWholeSalePrice' => $item['productWholeSalePrice'] ?? $product->productWholeSalePrice,
                'meta' => [
                    'productSalePrice' => $product->productSalePrice,
                    'productDealerPrice' => $product->productDealerPrice,
                    'productPurchasePrice' => $product->productPurchasePrice,
                    'productWholeSalePrice' => $product->productWholeSalePrice,
                ]
            ]);
        }

        if ($purchase->dueAmount || $request->dueAmount) {
            $party = Party::findOrFail($request->party_id);
            $party->update([
                'due' => $request->party_id == $purchase->party_id ? (($party->due - $purchase->dueAmount) + $request->dueAmount) : ($party->due + $request->dueAmount)
            ]);

            if ($request->party_id != $purchase->party_id) {
                $prev_party = Party::findOrFail($purchase->party_id);
                $prev_party->update([
                    'due' => $prev_party->due - $purchase->dueAmount
                ]);
            }
        }

        $business = Business::findOrFail(auth()->user()->business_id);
        $business->update([
            'remainingShopBalance' => ($business->remainingShopBalance + $purchase->paidAmount) - $request->paidAmount
        ]);

        $purchase->update($request->all() + [
            'user_id' => auth()->id(),
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $purchase->load('user:id,name', 'party:id,name,email,phone,type', 'details:id,purchase_id,product_id,productPurchasePrice,quantities', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName', 'purchaseReturns.details', 'vat:id,name,rate', 'payment_type:id,name'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        if ($purchase->dueAmount) {
            $party = Party::findOrFail($purchase->party_id);
            $party->update([
                'due' => $party->due - $purchase->dueAmount
            ]);
        }

        $business = Business::findOrFail(auth()->user()->business_id);
        $business->update([
            'remainingShopBalance' => $business->remainingShopBalance + $purchase->paidAmount
        ]);

        $prevDetails = PurchaseDetails::where('purchase_id', $purchase->id)->get();
        foreach ($prevDetails as $product) {
            $updateProduct = Product::findOrFail($product->product_id);
            $updateProduct->update([
                'productStock' => $updateProduct->productStock - (int) $product->quantities,
                'productSalePrice' => $updateProduct->meta['productSalePrice'] ?? $product->productSalePrice,
                'productDealerPrice' => $updateProduct->meta['productDealerPrice'] ?? $product->productDealerPrice,
                'productPurchasePrice' => $updateProduct->meta['productPurchasePrice'] ?? $product->productPurchasePrice,
                'productWholeSalePrice' => $updateProduct->meta['productWholeSalePrice'] ?? $product->productWholeSalePrice,
            ]);
        }

        $purchase->delete();

        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}
