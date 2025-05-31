<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Party;
use App\Models\Business;
use App\Models\Category;
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
        $productsArray = $products->map(function($product) {
            $badge = '';
            if ($product->productStock < 5) {
                $badge = 'Low Stock';
            } elseif ($product->created_at && $product->created_at->gt(now()->subDays(14))) {
                $badge = 'New';
            }
            return [
                'id' => $product->id,
                'name' => $product->productName,
                'price' => (float) $product->productSalePrice,
                'stock' => (int) $product->productStock,
                'category' => $product->category_id,
                'image' => $product->productPicture ? asset($product->productPicture) : asset('demo_images/default-product.png'),
                'description' => $product->meta['description'] ?? '',
                'brand' => $product->brand->brandName ?? '-',
                'badge' => $badge,
            ];
        })->values()->toArray();
        $business = Business::findOrFail($business_id);
        $categories = Category::where('business_id', $business_id)->orderBy('categoryName')->get();
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
        return view('business::products.marketplace', compact('products', 'orderHistory', 'customer', 'business_id', 'business', 'categories', 'productsArray'));
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

    /**
     * Get all products for a business by category (for View All logic)
     */
    public function getCategoryProducts($business_id, $category_id)
    {
        return Product::with(['category', 'brand', 'unit'])
            ->where('business_id', $business_id)
            ->where('category_id', $category_id)
            ->where('productStock', '>', 0)
            ->get();
    }

    /**
     * Show all products for a specific category (View All page/section)
     */
    public function viewAllCategory(Request $request, $business_id, $category_id)
    {
        $business = Business::findOrFail($business_id);
        $categories = Category::where('business_id', $business_id)->orderBy('categoryName')->get();
        $products = $this->getCategoryProducts($business_id, $category_id);
        $category = $categories->where('id', $category_id)->first();
        if (!$category) abort(404);
        // Optionally, you can reuse the same marketplace view and pass a flag for single-category mode
        return view('business::products.marketplace', compact('products', 'business', 'categories', 'category', 'category_id'));
    }

    // Store order from checkout (AJAX endpoint)
    public function storeCheckoutOrder(Request $request, $business_id)
    {
        // Fix: If business_id is not numeric, resolve it from subdomain
        if (!is_numeric($business_id)) {
            $businessModel = Business::where('subdomain', $business_id)->firstOrFail();
            $business_id = $businessModel->id;
        }

        $request->validate([
            'cart' => 'required|array|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:32',
            'customer_address' => 'nullable|string|max:255',
            'customer_city' => 'nullable|string|max:100',
            'customer_state' => 'nullable|string|max:100',
            'customer_zip' => 'nullable|string|max:20',
            'customer_instructions' => 'nullable|string|max:500',
        ]);

        \Log::info('storeCheckoutOrder request', $request->all());

        // Store guest customer for this business
        $customer = Party::firstOrCreate(
            [
                'business_id' => $business_id,
                'phone' => $request->customer_phone,
                'email' => $request->customer_email,
                'type' => 'Guest',
            ],
            [
                'name' => $request->customer_name,
                'address' => $request->customer_address,
                'city' => $request->customer_city,
                'state' => $request->customer_state,
                'zip' => $request->customer_zip,
                'type' => 'Guest',
                'status' => 1,
            ]
        );

        \Log::info('storeCheckoutOrder customer', ['customer' => $customer]);

        // Prepare sale data
        $cart = $request->cart;
        $subtotal = collect($cart)->sum(function($item) {
            return $item['price'] * $item['qty'];
        });
        $shipping = 10.00;
        $tax = $subtotal * 0.08;
        $totalAmount = $subtotal + $shipping + $tax;

        $products = collect($cart)->map(function($item) {
            return [
                'product_id' => $item['id'],
                'productName' => $item['name'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
            ];
        });

        $sale = Sale::create([
            'business_id' => $business_id,
            'party_id' => $customer->id,
            'user_id' => null, // guest order
            'source' => 'marketplace',
            'totalAmount' => $totalAmount,
            'paidAmount' => 0,
            'dueAmount' => $totalAmount,
            'isPaid' => 0,
            'products' => json_encode($products),
            'saleDate' => now(),
            'meta' => json_encode([
                'shipping' => $shipping,
                'tax' => $tax,
                'instructions' => $request->customer_instructions,
            ]),
        ]);

        \Log::info('storeCheckoutOrder sale', ['sale' => $sale]);

        // Optionally, store customer info in session for autofill
        session(['marketplace_customer_' . $business_id => [
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
        ]]);

        return response()->json(['success' => true, 'order_id' => $sale->id]);
    }

    /**
     * Show the marketplace for a business by subdomain (e.g. {business}.yourdomain.com)
     */
    public function showSubdomain(Request $request, $business)
    {
        // Find business by subdomain
        $businessModel = Business::where('subdomain', $business)->firstOrFail();
        // Reuse the show() logic by business_id
        return $this->show($businessModel->id);
    }
}
