<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Party;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class MarketplaceController extends Controller
{
    /**
     * Get all products for a business (with all details)
     */
    public function getBusinessProducts($business_id)
    {
        return Product::with(['category', 'brand', 'unit'])
            ->where('business_id', $business_id)
            ->where('productStock', '>', 0)
            ->get();
    }

    // Show marketplace for a given store (business_id)
    public function show($business_id)
    {
        $products = $this->getBusinessProducts($business_id);
        $customer = null;
        $orderHistory = collect();
        // Try to get customer info from session for autofill
        $sessionCustomer = session('marketplace_customer_' . $business_id, []);
        if (!empty($sessionCustomer['phone']) || !empty($sessionCustomer['email'])) {
            $customerQuery = Party::where('business_id', $business_id);
            if (!empty($sessionCustomer['phone'])) {
                $customerQuery->where('phone', $sessionCustomer['phone']);
            } elseif (!empty($sessionCustomer['email'])) {
                $customerQuery->where('email', $sessionCustomer['email']);
            }
            $customer = $customerQuery->first();
            if ($customer) {
                $orderHistory = Sale::where('business_id', $business_id)
                    ->where('party_id', $customer->id)
                    ->orderByDesc('created_at')
                    ->get();
            }
        }
        return view('business::products.marketplace', compact('products', 'orderHistory', 'customer', 'business_id'));
    }

    // Handle order submission for a product
    public function submitOrder(Request $request, $product_id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:32',
        ]);
        $business_id = $request->input('business_id');
        // Find or create customer (Party)
        $customer = Party::firstOrCreate(
            [
                'business_id' => $business_id,
                'phone' => $request->customer_phone,
            ],
            [
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'type' => 'Retailer',
                'status' => 1,
            ]
        );
        // Create Sale (order)
        $product = Product::findOrFail($product_id);
        $totalAmount = $product->productSalePrice * $request->quantity;
        $sale = Sale::create([
            'business_id' => $business_id,
            'party_id' => $customer->id,
            'user_id' => 1, // or auth()->id() if available
            'source' => 'marketplace',
            'totalAmount' => $totalAmount,
            'paidAmount' => 0,
            'dueAmount' => $totalAmount,
            'isPaid' => 0,
            'products' => json_encode([
                [
                    'product_id' => $product_id,
                    'productName' => $product->productName,
                    'quantity' => $request->quantity,
                    'price' => $product->productSalePrice,
                ]
            ]),
            'saleDate' => now(),
        ]);
        // Store customer info in session for autofill
        session(['marketplace_customer_' . $business_id => [
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
        ]]);
        return back()->with('success', __('Order submitted!'));
    }
}
