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

class SaleConfirmeController extends Controller
{
    public function index()
    {
         $sale = Sale::with(
            'user:id,name',
            'party:id,name,email,phone,type',
            'payment_type:id,name'
        )
            ->where('business_id', auth()->user()->business_id)->whereIn('sale_status', [1, 2, 3, 4, 5])
            ->latest();

        // Decode the products field to get the array of objects
        $products = is_array($sale->products) ? $sale->products : json_decode($sale->products, true) ?? [];

        if (empty($products)) {
            return redirect()->back()->with('error', __('Products list not found.'));
        }

        // Fetch product details from the database
        $productIds = collect($products)->pluck('id')->toArray();
        $productDetails = Product::whereIn('id', $productIds)->get();

        // Map products with their details
        $productsWithDetails = collect($products)->map(function ($product) use ($productDetails) {
            $productDetail = $productDetails->where('id', $product['id'])->first();
            return [
                'id' => $product['id'],
                'name' => $productDetail->productName ?? 'Unknown Product',
                'category' => $productDetail->category->categoryName ?? 'N/A',
                'quantity' => $product['quantity'] ?? 0,
                'price' => $productDetail->productSalePrice ?? 0,
                'subtotal' => ($product['quantity'] ?? 0) * ($productDetail->productSalePrice ?? 0),
            ];
        });

        // Return the view for showing order details
        return view('business::sales.order-view', compact('sale', 'productsWithDetails'));
    }
}


