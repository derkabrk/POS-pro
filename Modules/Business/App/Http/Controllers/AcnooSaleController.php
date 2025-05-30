<?php

namespace Modules\Business\App\Http\Controllers;

use App\Helpers\HasUploader;
use App\Models\PaymentType;
use App\Models\Vat;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Brand;
use App\Models\Party;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingCompanies;
use App\Models\Business;
use App\Models\Category;
use App\Models\OrderSource;
use App\Models\SaleReturn;
use App\Models\SaleDetails;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class AcnooSaleController extends Controller
{
    use HasUploader;

    public function index(Request $request)
    {
        if (!auth()->user()) {
            return redirect()->back()->with('error', __('You have no permission to access.'));
        }

        // Retrieve the business_id from the authenticated user
        $businessId = auth()->user()->business_id;

        // Fetch OrderSources for the dropdown
        $orderSources = OrderSource::where('business_id', $businessId)->get();

        // Fetch sales with returns
        $salesWithReturns = SaleReturn::where('business_id', $businessId)
            ->pluck('sale_id')
            ->toArray();

        // Build the query for sales
        $query = Sale::with('user:id,name', 'party:id,name,email,phone,type', 'details', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName', 'payment_type:id,name')
            ->where('business_id', $businessId)
            ->latest();

        // Apply filters
        if ($request->has('order_source_id') && $request->order_source_id) {
            $query->where('order_source_id', $request->order_source_id);
        }

        if ($request->has('today') && $request->today) {
            $query->whereDate('created_at', Carbon::today());
        }

        // Paginate the results
        $sales = $query->paginate(20);

        return view('business::sales.index', compact('sales', 'salesWithReturns', 'orderSources'));
    }

    public function acnoofilter(Request $request)
    {
        $query = Sale::with('user', 'party', 'details', 'payment_type')
            ->where('business_id', auth()->user()->business_id);

        // Apply sale_type filter
        if ($request->filled('sale_type')) {
            $query->where('sale_type', $request->sale_type);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('invoiceNumber', 'like', '%' . $request->search . '%')
                    ->orWhereHas('party', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $sales = $query->paginate($request->per_page ?? 10);

        return response()->json([
            'html' => view('business::sales.datas', compact('sales'))->render()
        ]);
    }


    public function productFilter(Request $request)
    {
        $total_products_count = Product::where('business_id', auth()->user()->business_id)->count();
        $products = Product::where('business_id', auth()->user()->business_id)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('productName', 'like', '%' . $request->search . '%')
                        ->orWhere('productCode', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->when($request->brand_id, function ($query) use ($request) {
                $query->where('brand_id', $request->brand_id);
            })
            ->latest()
            ->get();

        // Query categories for search options
        $categories = Category::where('business_id', auth()->user()->business_id)
            ->when($request->search, function ($query) use ($request) {
                $query->where('categoryName', 'like', '%' . $request->search . '%');
            })
            ->get();

        // Query brands for search options
        $brands = Brand::where('business_id', auth()->user()->business_id)
            ->when($request->search, function ($query) use ($request) {
                $query->where('brandName', 'like', '%' . $request->search . '%');
            })
            ->get();

        $total_products = $products->count();

        if ($request->ajax()) {
            return response()->json([
                'total_products' => $total_products,
                'total_products_count' => $total_products_count,
                'product_id' => $total_products == 1 ? $products->first()->id : null,
                'data' => view('business::sales.product-list', compact('products'))->render(),
                'categories' => view('business::sales.category-list', compact('categories'))->render(),
                'brands' => view('business::sales.brand-list', compact('brands'))->render(),
            ]);
        }

        return redirect(url()->previous());
    }

    // Category search Filter
    public function categoryFilter(Request $request)
    {
        $search = $request->search;
        $categories = Category::where('business_id', auth()->user()->business_id)
            ->when($search, function ($query) use ($search) {
                $query->where('categoryName', 'like', '%' . $search . '%');
            })
            ->get();

        return response()->json([
            'categories' => view('business::sales.category-list', compact('categories'))->render(),
        ]);
    }

    // Brand search Filter
    public function brandFilter(Request $request)
    {
        $search = $request->search;
        $brands = Brand::where('business_id', auth()->user()->business_id)
            ->when($search, function ($query) use ($search) {
                $query->where('brandName', 'like', '%' . $search . '%');
            })
            ->get();

        return response()->json([
            'brands' => view('business::sales.brand-list', compact('brands'))->render(),
        ]);
    }

    public function create()
    {
        // Clears all cart items
        Cart::destroy();

        $customers = Party::where('type', '!=', 'supplier')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();
        $products = Product::with('category:id,categoryName', 'unit:id,unitName')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();

        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        $jsonPath = storage_path('app/Wilaya_Of_Algeria.json');
        if (!File::exists($jsonPath)) {
            abort(500, "Wilaya JSON file not found!");
        }
        $json = File::get($jsonPath);
        $wilayas = json_decode($json, true);

        $communesPath = storage_path('app/communes.json');

        if (!File::exists($communesPath)) {
            abort(500, "Commune JSON file not found!");
        }

        $communesJson = File::get($communesPath);
        $communes = json_decode($communesJson, true);

        if (empty($communes)) {
            dd("Error: Communes data is empty!", $communes);
        }

        $categories = Category::where('business_id', auth()->user()->business_id)->latest()->get();
        $shippings = Shipping::where('business_id', auth()->user()->business_id)->paginate(20);
        $brands = Brand::where('business_id', auth()->user()->business_id)->latest()->get();
        $vats = Vat::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $payment_types = PaymentType::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();

        // Generate a unique invoice number
        $sale_id = (Sale::max('id') ?? 0) + 1;
        $invoice_no = 'S-' . str_pad($sale_id, 5, '0', STR_PAD_LEFT);

        return view('business::sales.create', compact('customers', 'wilayas', 'communes', 'shippings', 'products', 'cart_contents', 'invoice_no', 'categories', 'brands', 'vats', 'payment_types'));
    }

    /** Get Product wise prices */
    public function getProductPrices(Request $request)
    {
        $type = $request->type;

        $products = Product::where('business_id', auth()->user()->business_id)->get();
        $prices = [];

        foreach ($products as $product) {
            if ($type === 'Dealer') {
                $prices[$product->id] = currency_format($product->productDealerPrice, 'icon', 2, business_currency());
            } elseif ($type === 'Wholesaler') {
                $prices[$product->id] = currency_format($product->productWholeSalePrice, 'icon', 2, business_currency());
            } else {
                // For Retailer or any other type
                $prices[$product->id] = currency_format($product->productSalePrice, 'icon', 2, business_currency());
            }
        }
        return response()->json($prices);
    }

    /** Get cart info */
    public function getCartData()
    {
        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        $data['sub_total'] = 0;

        foreach ($cart_contents as $cart) {
            $data['sub_total'] += $cart->price;
        }
        $data['sub_total'] = currency_format($data['sub_total'], 'icon', 2, business_currency());

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoiceNumber' => 'required|string',
            'customer_phone' => 'nullable|string',
            'receive_amount' => 'nullable|numeric',
            'vat_id' => 'nullable|exists:vats,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'discountAmount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:flat,percent',
            'shipping_charge' => 'nullable|numeric',
            'saleDate' => 'nullable|date',
            'sale_type' => 'required|integer|in:0,1',
            'sale_status' => 'nullable|integer',
            'delivery_type' => 'nullable|integer',
            'parcel_type' => 'nullable|integer',
        ]);

        $business_id = auth()->user()->business_id;
        $carts = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        if ($carts->count() < 1) {
            return response()->json(['message' => __('Cart is empty. Add items first!')], 400);
        }

        $saleData = [
            'sale_type' => $validated['sale_type'],
        ];

        if ($validated['sale_type'] == 1) {
            $saleData['sale_status'] = $validated['sale_status'] ?? 1;
            $saleData['shipping_service_id'] = $request['shipping_service_id'] ?? null;
            $saleData['delivery_address'] = $request['delivery_address'] ?? null;
            $saleData['wilaya_id'] = $request['shipping_wilaya_id'] ?? null;
            $saleData['commune_id'] = $request['commune_id'] ?? null;
        } else {
            $saleData['sale_status'] = 7;
        }

        DB::beginTransaction();
        try {
            // Stock availability check
            $productIds = $carts->pluck('id')->toArray();
            $products = Product::whereIn('id', $productIds)->get();
            $totalPurchaseAmount = 0;

            foreach ($products as $product) {
                $cartItemQuantity = $carts->where('id', $product->id)->first()->qty;
                if ($product->productStock < $cartItemQuantity) {
                    return response()->json([
                        'message' => __($product->productName . ' - stock not available for this product. Available quantity is: ' . $product->productStock)
                    ], 400);
                }
                $totalPurchaseAmount += $product->productPurchasePrice * $cartItemQuantity;
            }

            // Subtotal
            $subtotal = $carts->sum(function ($cartItem) {
                return (float) $cartItem->subtotal;
            });

            // VAT
            $vat = Vat::find($request->vat_id);
            $vatAmount = 0;
            if ($vat) {
                $vatAmount = ($subtotal * $vat->rate) / 100;
            }

            // Discount
            $discountAmount = $request->discountAmount ?? 0;
            if ($request->discount_type == 'percent') {
                $discountAmount = ($subtotal * $discountAmount) / 100;
            }
            if ($discountAmount > $subtotal) {
                return response()->json([
                    'message' => __('Discount cannot be more than subtotal!')
                ], 400);
            }

            // Shipping Charge
            $shippingCharge = $request->shipping_charge ?? 0;

            // Total Amount
            $totalAmount = $subtotal + $vatAmount - $discountAmount + $shippingCharge;

            // Receive, Change, Due Amount Calculation
            $receiveAmount = $request->receive_amount ?? 0;
            $changeAmount = $receiveAmount > $totalAmount ? $receiveAmount - $totalAmount : 0;
            $dueAmount = max($totalAmount - $receiveAmount, 0);
            $paidAmount = $receiveAmount - $changeAmount;

            // Update business balance
            $business = Business::findOrFail($business_id);
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance + $paidAmount,
            ]);

            // Prepare products array with new structure
            $productsArray = $carts->map(function ($cartItem) {
                return [
                    'id' => $cartItem->id,
                    'quantity' => $cartItem->qty,
                ];
            })->toArray();

            // Create Sale record
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'business_id' => $business_id,
                'party_id' => $request->party_id == 'guest' ? null : $request->party_id,
                'invoiceNumber' => $request->invoiceNumber,
                'saleDate' => $request->saleDate ?? now(),
                'vat_id' => $request->vat_id,
                'vat_amount' => $vatAmount,
                'discountAmount' => $discountAmount,
                'discount_type' => $request->discount_type ?? 'flat',
                'discount_percent' => $request->discount_type == 'percent' ? $request->discountAmount : 0,
                'totalAmount' => $totalAmount,
                'lossProfit' => $subtotal - $totalPurchaseAmount - $discountAmount,
                'paidAmount' => $paidAmount > $totalAmount ? $totalAmount : $paidAmount,
                'dueAmount' => $dueAmount,
                'sale_type' => $request->sale_type === "1" ? 1 : 0,
                'payment_type_id' => $request->payment_type_id,
                'shipping_charge' => $shippingCharge,
                'isPaid' => $dueAmount > 0 ? 0 : 1,
                'sale_status' => $saleData['sale_status'],
                'products' => $productsArray, // Store products with new structure
                'wilaya_id' => $saleData['wilaya_id'],
                'commune_id' => $saleData['commune_id'],
                'shipping_service_id' => $saleData['shipping_service_id'],
                'delivery_address' => $saleData['delivery_address'],
                'delivery_type' => $request->delivery_type,
                'parcel_type' => $request->parcel_type,
                'meta' => [
                    'customer_phone' => $request->customer_phone,
                    'note' => $request->note,
                ]
            ]);

            // Calculate average discount per product
            $avgDiscount = $discountAmount / $carts->count();

            // Prepare sale details and update stock
            $saleDetailsData = [];
            foreach ($carts as $cartItem) {
                $product = $products->where('id', $cartItem->id)->first();
                $lossProfit = (($cartItem->price - $product->productPurchasePrice) * $cartItem->qty) - $avgDiscount;

                $saleDetailsData[] = [
                    'sale_id' => $sale->id,
                    'product_id' => $cartItem->id,
                    'price' => $cartItem->price,
                    'lossProfit' => $lossProfit,
                    'quantities' => $cartItem->qty,
                ];

                Product::findOrFail($cartItem->id)->decrement('productStock', $cartItem->qty);
            }

            // Bulk insert sale details
            SaleDetails::insert($saleDetailsData);

            // Handle due and messaging for party
            if ($dueAmount > 0) {
                if (!$request->party_id || $request->party_id == 'guest') {
                    return response()->json([
                        'message' => __('You cannot sale in due for a walking customer.')
                    ], 400);
                }

                $party = Party::findOrFail($request->party_id);
                $party->update(['due' => $party->due + $dueAmount]);

                if ($party->phone && env('MESSAGE_ENABLED')) {
                    sendMessage($party->phone, saleMessage($sale, $party, $business->companyName));
                }
            }

            // Clear the cart
            $carts = Cart::content()->filter(fn($item) => $item->options->type == 'sale');
            foreach ($carts as $cartItem) {
                Cart::remove($cartItem->rowId);
            }

            sendNotifyToUser($sale->id, route('business.sales.index', ['id' => $sale->id]), __('New sale created.'), $business_id);

            DB::commit();

            return response()->json([
                'message' => __('Sales created successfully.'),
                'redirect' => route('business.sales.index'),
                'secondary_redirect_url' => route('business.sales.invoice', $sale->id),
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => __('Something went wrong!'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeNonExistingProducts(string $authToken, array $products): array 
    {
        // Step 1: Fetch existing Maystro products
        $response = Http::withHeaders([
            'Authorization' => $authToken,
        ])->get('https://backend.maystro-delivery.com/api/stores/product/?limit=500');
    
        $json = $response->json();
        $results = $json['list']['results'] ?? [];
    
        if (empty($results)) {
            \Log::error('Maystro response missing product list or empty');
            return [];
        }
    
        $storeId = $results[0]['store'] ?? null;
        if (!$storeId) {
            \Log::error('store_id not found in first Maystro product');
            return [];
        }
    
        // Step 2: Map existing Maystro products by your original product_id
        $maystroMap = collect($results)->mapWithKeys(function ($item) {
            return [(string) $item['product_id'] => $item];
        });
    
        $finalProducts = [];
    
        // Step 3: Loop through local products
        foreach ($products as $product) {
            $product = (array) $product;
            $id = isset($product['id']) ? (string) $product['id'] : null;
            $name = $product['productName'] ?? $product['product_name'] ?? null;
            $quantity = $product['quantity'] ?? 1; // Default to 1 if quantity is not provided
    
            if (!$id || !$name || !ctype_digit($id)) {
                \Log::warning('Invalid product format - skipping', ['product' => $product]);
                continue;
            }
    
            // Step 4: If product exists in Maystro
            if (isset($maystroMap[$id])) {
                $existing = $maystroMap[$id];
    
                if (!isset($existing['product_id']) || !isset($existing['logistical_description'])) {
                    \Log::warning('Maystro existing product missing keys', ['product' => $existing]);
                    continue;
                }
    
                $finalProducts[] = [
                    'product_id' => (string) $existing['product_id'], // Must be numeric string
                    'logistical_description' => $existing['logistical_description'],
                    'quantity' => $quantity, // Include quantity
                ];
                continue;
            }
    
            // Step 5: Create missing product in Maystro
            $create = Http::withHeaders([
                'Authorization' => $authToken,
            ])->post('https://backend.maystro-delivery.com/api/stores/product/', [
                'store_id' => $storeId,
                'logistical_description' => $name,
                'product_id' => $id,
            ]);
    
            if ($create->successful() || $create->status() === 201) {
                $created = $create->json();
    
                if (!isset($created['logistical_description'])) {
                    \Log::error('Maystro create product response missing fields', ['response' => $created]);
                    continue;
                }
    
                $finalProducts[] = [
                    'product_id' => $id, // Send your original store-assigned product ID
                    'logistical_description' => $created['logistical_description'],
                    'quantity' => $quantity, // Include quantity
                ];
            } else {
                \Log::error('Maystro product creation failed', [
                    'product_id' => $id,
                    'status' => $create->status(),
                    'body' => $create->body(),
                ]);
            }
        }
    
        return $finalProducts;
    }
    
    

    

    public function show($id)
    {
        // Fetch sale details
        $sale = Sale::with(
            'user:id,name',
            'party:id,name,email,phone,type',
            'details',
            'details.product:id,productName,category_id',
            'details.product.category:id,categoryName',
            'payment_type:id,name'
        )
            ->where('business_id', auth()->user()->business_id)
            ->findOrFail($id);

        // Fetch sales with returns
        $salesWithReturns = SaleReturn::where('business_id', auth()->user()->business_id)
            ->pluck('sale_id')
            ->toArray();

        return response()->json([
            'html' => view('business::sales.confirmed-orders', compact('sales', 'salesWithReturns'))->render()
        ]);
    }

    public function showOrder($id)
    {
        // Fetch sale details with related data
        $sale = Sale::with(
            'user:id,name',
            'party:id,name,email,phone,type',
            'payment_type:id,name'
        )
            ->where('business_id', auth()->user()->business_id)
            ->findOrFail($id);

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
                'image' => $productDetail->image ?? null, // 
                'subtotal' => ($product['quantity'] ?? 0) * ($productDetail->productSalePrice ?? 0),
            ];
        });

        // Return the view for showing order details
        return view('business::sales.order-view', compact('sale', 'productsWithDetails'));
    }

    public function edit($id)
    {
        // Clears all cart items
        Cart::destroy();

        $sale = Sale::with('user:id,name', 'party:id,name,email,phone,type', 'details', 'details.product:id,productName,category_id,unit_id,productCode,productSalePrice,productPicture', 'details.product.category:id,categoryName', 'details.product.unit:id,unitName', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->findOrFail($id);

        $customers = Party::where('type', '!=', 'supplier')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();

        $products = Product::with('category:id,categoryName', 'unit:id,unitName')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();
   

        $categories = Category::where('business_id', auth()->user()->business_id)->latest()->get();
        $brands = Brand::where('business_id', auth()->user()->business_id)->latest()->get();
        $vats = Vat::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $payment_types = PaymentType::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();

        // Add sale details to the cart
        foreach ($sale->details as $detail) {
            // Add to cart
            Cart::add([
                'id' => $detail->product_id,
                'name' => $detail->product->productName ?? '',
                'qty' => $detail->quantities,
                'price' => $detail->price ?? 0,
                'options' => [
                    'type' => 'sale',
                    'product_code' => $detail->product->productCode ?? '',
                    'product_unit_id' => $detail->product->unit_id ?? null,
                    'product_unit_name' => $detail->product->unit->unitName ?? '',
                    'product_image' => $detail->product->productPicture ?? '',
                ],
            ]);
        }

        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        return view('business::sales.edit', compact('sale', 'customers', 'products', 'cart_contents', 'categories', 'brands', 'vats', 'payment_types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoiceNumber' => 'required|string',
            'customer_phone' => 'nullable|string',
            'receive_amount' => 'nullable|numeric',
            'vat_id' => 'nullable|exists:vats,id',
            'payment_type_id' => 'required|exists:payment_types,id',
            'discountAmount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:flat,percent',
            'saleDate' => 'nullable|date',
            'shipping_charge' => 'nullable|numeric',
        ]);

        $business_id = auth()->user()->business_id;
        $carts = Cart::content()->filter(fn($item) => $item->options->type == 'sale');

        if ($carts->count() < 1) {
            return response()->json(['message' => __('Cart is empty. Add items first!')], 400);
        }


        DB::beginTransaction();
        try {
            $sale = Sale::findOrFail($id);
            $sale_prev_due = $sale->dueAmount;

            // Revert previous stock adjustments
            $previousSaleDetails = $sale->details;
            foreach ($previousSaleDetails as $detail) {
                Product::findOrFail($detail->product_id)->increment('productStock', $detail->quantities);
            }

            // Stock availability check for new data
            $productIds = $carts->pluck('id')->toArray();
            $products = Product::whereIn('id', $productIds)->get();
            $totalPurchaseAmount = 0;

            foreach ($products as $product) {
                $cartItemQuantity = $carts->where('id', $product->id)->first()->qty;
                if ($product->productStock < $cartItemQuantity) {
                    return response()->json([
                        'message' => __($product->productName . ' - stock not available for this product. Available quantity is: ' . $product->productStock)
                    ], 400);
                }
                // Calculate the total purchase amount
                $totalPurchaseAmount += $product->productPurchasePrice * $cartItemQuantity;
            }

            // Subtotal
            $subtotal = $carts->sum(function ($cartItem) {
                return (float) $cartItem->subtotal;
            });


            // Vat
            $vat = Vat::find($request->vat_id);
            $vatAmount = 0;
            if ($vat) {
                $vatAmount = ($subtotal * $vat->rate) / 100;
            }

            //Discount
            $discountAmount = $request->discountAmount ?? 0;
            if ($request->discount_type == 'percent') {
                $discountAmount = ($subtotal * $discountAmount) / 100;
            }
            if ($discountAmount > $subtotal) {
                return response()->json([
                    'message' => __('Discount cannot be more than subtotal!')
                ], 400);
            }

            // Shipping Charge
            $shippingCharge = $request->shipping_charge ?? 0;

            // Total Amount
            $totalAmount = $subtotal + $vatAmount - $discountAmount + $shippingCharge;

            // Receive, Change, Due Amount Calculation
            $receiveAmount = $request->receive_amount ?? 0;
            $changeAmount = $receiveAmount > $totalAmount ? $receiveAmount - $totalAmount : 0;
            $dueAmount = max($totalAmount - $receiveAmount, 0);
            $paidAmount = $receiveAmount - $changeAmount;

            // Update business balance
            $business = Business::findOrFail($business_id);
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance + $paidAmount - $sale->paidAmount,
            ]);

            // Update Sale record
            $sale->update([
                'invoiceNumber' => $request->invoiceNumber,
                'saleDate' => $request->saleDate ?? now(),
                'vat_id' => $request->vat_id,
                'vat_amount' => $vatAmount,
                'discountAmount' => $discountAmount,
                'discount_type' => $request->discount_type ?? 'flat',
                'discount_percent' => $request->discount_type == 'percent' ? $request->discountAmount : 0,
                'totalAmount' => $totalAmount,
                'lossProfit' => $subtotal - $totalPurchaseAmount - $discountAmount,
                'paidAmount' => $paidAmount > $totalAmount ? $totalAmount : $paidAmount,
                'dueAmount' => $dueAmount,
                'payment_type_id' => $request->payment_type_id,
                'isPaid' => $dueAmount > 0 ? 0 : 1,
                'meta' => [
                    'customer_phone' => $request->customer_phone,
                    'note' => $request->note,
                ]
            ]);

            // Remove old sale details and update stock
            SaleDetails::where('sale_id', $sale->id)->delete();

            // Calculate average discount per product
            $avgDiscount = $discountAmount / $carts->count();

            // Prepare sale details and update stock
            $saleDetailsData = [];
            foreach ($carts as $cartItem) {
                $product = $products->where('id', $cartItem->id)->first();
                $lossProfit = (($cartItem->price - $product->productPurchasePrice) * $cartItem->qty) - $avgDiscount;

                $saleDetailsData[] = [
                    'sale_id' => $sale->id,
                    'product_id' => $cartItem->id,
                    'price' => $cartItem->price,
                    'lossProfit' => $lossProfit,
                    'quantities' => $cartItem->qty,
                ];

                Product::findOrFail($cartItem->id)->decrement('productStock', $cartItem->qty);
            }

            // Bulk insert updated sale details
            SaleDetails::insert($saleDetailsData);

            // Handle due and messaging for party
            if ($dueAmount > 0) {
                if (!$request->party_id || $request->party_id == 'guest') {
                    return response()->json([
                        'message' => __('You cannot sale in due for a walking customer.')
                    ], 400);
                }

                $party = Party::findOrFail($request->party_id);
                $party->update(['due' => $party->due + $dueAmount - $sale_prev_due]);

                if ($party->phone && env('MESSAGE_ENABLED')) {
                    sendMessage($party->phone, saleMessage($sale, $party, $business->companyName));
                }
            }


            // Clear the cart
            foreach ($carts as $cartItem) {
                Cart::remove($cartItem->rowId);
            }

            sendNotifyToUser($sale->id, route('business.sales.index', ['id' => $sale->id]), __('Sale has been updated.'), $business_id);

            DB::commit();

            return response()->json([
                'message' => __('Sales updated successfully.'),
                'redirect' => route('business.sales.index'),
                'secondary_redirect_url' => route('business.sales.invoice', $sale->id),
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $sale = Sale::findOrFail($id);

            foreach ($sale->details as $detail) {
                Product::findOrFail($detail->product_id)->increment('productStock', $detail->quantities);
            }

            if ($sale->party_id) {
                $party = Party::findOrFail($sale->party_id);
                $party->update(['due' => $party->due - $sale->dueAmount]);
            }

            sendNotifyToUser($sale->id, route('business.sales.index', ['id' => $sale->id]), __('Sale has been deleted.'), $sale->business_id);

            $sale->delete();

            // Clears all cart items
            Cart::destroy();

            DB::commit();

            return response()->json([
                'message' => __('Sale deleted successfully.'),
                'redirect' => route('business.sales.index')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }

    public function getInvoice($sale_id)
    {
        $sale = Sale::where('business_id', auth()->user()->business_id)->with('user:id,name', 'party:id,name,phone', 'business:id,phoneNumber,companyName,vat_name,vat_no', 'details:id,price,quantities,product_id,sale_id', 'details.product:id,productName', 'payment_type:id,name')->findOrFail($sale_id);

        $sale_returns = SaleReturn::with('sale:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'sale.party:id,name', 'details', 'details.saleDetail.product:id,productName')
            ->where('business_id', auth()->user()->business_id)
            ->where('sale_id', $sale_id)
            ->latest()
            ->get();

        // sum of  return_qty
        $sale->details = $sale->details->map(function ($detail) use ($sale_returns) {
            $return_qty_sum = $sale_returns->flatMap(function ($return) use ($detail) {
                return $return->details->where('saleDetail.id', $detail->id)->pluck('return_qty');
            })->sum();

            $detail->quantities = $detail->quantities + $return_qty_sum;
            return $detail;
        });

        // Calculate the initial discount for each product during sale returns
        $total_discount = 0;
        $product_discounts = [];

        foreach ($sale_returns as $return) {
            foreach ($return->details as $detail) {
                // Add the return quantities and return amounts for each sale_detail_id
                if (!isset($product_discounts[$detail->sale_detail_id])) {
                    // Initialize the first occurrence
                    $product_discounts[$detail->sale_detail_id] = [
                        'return_qty' => 0,
                        'return_amount' => 0,
                        'price' => $detail->saleDetail->price,
                    ];
                }

                // Accumulate quantities and return amounts for the same sale_detail_id
                $product_discounts[$detail->sale_detail_id]['return_qty'] += $detail->return_qty;
                $product_discounts[$detail->sale_detail_id]['return_amount'] += $detail->return_amount;
            }
        }

        // Calculate the total discount based on accumulated quantities and return amounts
        foreach ($product_discounts as $data) {
            $product_price = $data['price'] * $data['return_qty'];
            $discount = $product_price - $data['return_amount'];

            $total_discount += $discount;
        }

        return view('business::sales.invoice', compact('sale', 'sale_returns', 'total_discount'));
    }

    public function deleteAll(Request $request)
    {
        DB::beginTransaction();

        try {
            $sales = Sale::whereIn('id', $request->ids)->get();

            foreach ($sales as $sale) {
                foreach ($sale->details as $detail) {
                    Product::findOrFail($detail->product_id)->increment('productStock', $detail->quantities);
                }

                if ($sale->party_id) {
                    $party = Party::findOrFail($sale->party_id);
                    $party->update(['due' => $party->due - $sale->dueAmount]);
                }

                sendNotifyToUser($sale->id, route('business.sales.index', ['id' => $sale->id]), __('Sale has been deleted.'), $sale->business_id);
                $sale->delete();
            }

            // Clears all cart items
            Cart::destroy();

            DB::commit();

            return response()->json([
                'message' => __('Selected sales deleted successfully.'),
                'redirect' => route('business.sales.index')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }

    public function generatePDF(Request $request, $sale_id)
    {
        $sale = Sale::where('business_id', auth()->user()->business_id)->with('user:id,name', 'party:id,name,phone', 'business:id,phoneNumber,companyName,vat_name,vat_no', 'details:id,price,quantities,product_id,sale_id', 'details.product:id,productName', 'payment_type:id,name')->findOrFail($sale_id);

        $sale_returns = SaleReturn::with('sale:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'sale.party:id,name', 'details', 'details.saleDetail.product:id,productName')
            ->where('business_id', auth()->user()->business_id)
            ->where('sale_id', $sale_id)
            ->latest()
            ->get();

        // sum of  return_qty
        $sale->details = $sale->details->map(function ($detail) use ($sale_returns) {
            $return_qty_sum = $sale_returns->flatMap(function ($return) use ($detail) {
                return $return->details->where('saleDetail.id', $detail->id)->pluck('return_qty');
            })->sum();

            $detail->quantities = $detail->quantities + $return_qty_sum;
            return $detail;
        });

        $pdf = Pdf::loadView('business::sales.pdf', compact('sale', 'sale_returns'));
        return $pdf->download('sales-invoice.pdf');
    }

    public function sendMail(Request $request, $sale_id)
    {
        $sale = Sale::with('user:id,name', 'party:id,name,phone', 'business:id,phoneNumber,companyName,vat_name,vat_no', 'details:id,price,quantities,product_id,sale_id', 'details.product:id,productName', 'payment_type:id,name')
            ->findOrFail($sale_id);

        $sale_returns = SaleReturn::with('sale:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'sale.party:id,name', 'details', 'details.saleDetail.product:id,productName')
            ->where('business_id', auth()->user()->business_id)
            ->where('sale_id', $sale_id)
            ->latest()
            ->get();

        // sum of  return_qty
        $sale->details = $sale->details->map(function ($detail) use ($sale_returns) {
            $return_qty_sum = $sale_returns->flatMap(function ($return) use ($detail) {
                return $return->details->where('saleDetail.id', $detail->id)->pluck('return_qty');
            })->sum();

            $detail->quantities = $detail->quantities + $return_qty_sum;
            return $detail;
        });
        $pdf = Pdf::loadView('business::sales.pdf', compact('sale', 'sale_returns'));


        // Send email with PDF attachment
        Mail::raw('Please find attached your sales invoice.', function ($message) use ($pdf) {
            $message->to(auth()->user()->email)
                ->subject('Sales Invoice')
                ->attachData($pdf->output(), 'sales-invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
        });

        return response()->json([
            'message' => __('Email Sent Successfully.'),
            'redirect' => route('business.sales.index'),
        ]);

    }

    public function createCustomer(Request $request)
    {
        $request->validate([
            'phone' => 'required|max:20|unique:parties,phone',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Retailer,Dealer,Wholesaler,Supplier',
            'email' => 'nullable|email',
            'image' => 'nullable|image|max:1024',
            'address' => 'nullable|string|max:255',
            'due' => 'nullable|numeric|min:0',
        ]);

        Party::create($request->except('image', 'due') + [
            'due' => $request->due ?? 0,
            'image' => $request->image ? $this->upload($request, 'image') : NULL,
            'business_id' => auth()->user()->business_id
        ]);

        return response()->json([
            'message' => __('Customer created successfully'),
            'redirect' => route('business.sales.create')
        ]);

    }



    public function updatestatus(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'sale_status' => 'required|integer',
            'redirect_from' => 'nullable|string|in:orders_table,confirm_user',
        ]);

        $sale = Sale::findOrFail($request->sale_id);
        $old_status = $sale->sale_status;
        $sale->update(['sale_status' => $request->sale_status]);

        // Log the status update
        \App\Models\OrderStatusUpdate::create([
            'user_id' => auth()->id(),
            'sale_id' => $sale->id,
            'old_status' => $old_status,
            'new_status' => $request->sale_status,
        ]);

        if ($sale->sale_type != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update status for Business Sale'
            ]);
        }

        if ($sale->sale_status != 7) {
            // Fix: If AJAX, return JSON; if not, redirect
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => __('Sale Status updated Successfully'),
                    'redirect' => route('business.sales.index'),
                ]);
            } else {
                return redirect()->route('business.sales.index')->with('success', __('Sale Status updated successfully.'));
            }
        }

        // Decode the products field to get the array of objects
        $products = is_array($sale->products) ? $sale->products : json_decode($sale->products, true) ?? [];

        if (empty($products)) {
            return response()->json(['message' => 'Products list not found'], 404);
        }

        // Fetch product details from the database
        $productIds = collect($products)->pluck('id')->toArray();
        $productDetails = Product::whereIn('id', $productIds)->get();

        if ($productDetails->isEmpty()) {
            return response()->json(['message' => 'Products not found in the database'], 404);
        }

        // Map products with their quantities
        $productsWithDetails = collect($products)->map(function ($product) use ($productDetails) {
            $productDetail = $productDetails->where('id', $product['id'])->first();
            return [
                'id' => $product['id'],
                'quantity' => $product['quantity'],
                'productName' => $productDetail->productName ?? 'Unknown Product',
            ];
        });

        $customer = Party::find($sale->party_id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        if (!$sale->wilaya_id || !$sale->commune_id) {
            return response()->json(['message' => 'wilaya_id or commune_id not found'], 404);
        }

        $shippingService = Shipping::find($sale->shipping_service_id);
        $shippingCompany = ShippingCompanies::find($shippingService->shipping_company_id ?? null);

        if (!$shippingService || !$shippingCompany) {
            return response()->json(['message' => 'Shipping service not found'], 404);
        }

        $apiUrl = $shippingCompany->create_api_url;
        $headers = ['Accept' => 'application/json'];
        $payload = [];

        if ($shippingService->shipping_company_id == 1) {
            $headers["token"] = $shippingService->first_r_credential;
            $headers["key"] = $shippingService->second_r_credential;

            $colis = $productsWithDetails->map(function ($product) use ($sale, $customer) {
                return [
                    "Tracking"      => $sale->tracking_id,
                    "TypeLivraison" => (int) ($sale->delivery_type ?? 0),
                    "TypeColis"     => (int) ($sale->parcel_type ?? 0),
                    "Confirmee"     => 0,
                    "Client"        => $customer->name,
                    "MobileA"       => $customer->phone,
                    "MobileB"       => $customer->phone,
                    "Adresse"       => $sale->delivery_address,
                    "IDWilaya"      => (int) $sale->wilaya_id,
                    "Commune"       => "Maraval",
                    "Total"         => (float) $sale->totalAmount,
                    "Note"          => "",
                    "TProduit" => $product['productName'] . '(' . $product['quantity'] . ')',
                    "id_Externe"    => $sale->tracking_id . '-' . $product['id'],
                    "Source"        => ""
                ];
            })->toArray();

            $payload = [
                "Colis" => $colis
            ];
        } elseif ($shippingService->shipping_company_id == 2) {
            $authToken = $shippingService->first_r_credential;
            $headers["Authorization"] = "Token $authToken";

            $cleanedProducts = $productsWithDetails->map(function ($product) {
                return [
                    'id' => $product['id'],
                    'productName' => $product['productName'],
                ];
            })->toArray();

            $createdProducts = $this->storeNonExistingProducts("Token $authToken", $cleanedProducts);

            $payload = [
                "external_order_id" => $sale->tracking_id,
                "source" => 4,
                "wilaya" => $sale->wilaya_id,
                "commune" => $sale->commune_id,
                "destination_text" => $sale->delivery_address,
                "customer_phone" => $customer->phone,
                "customer_name" => $customer->name,
                "product_price" => (int) ($sale->totalAmount + $sale->shipping_charge),
                "express" => false,
                "note_to_driver" => "",
                "products" => $createdProducts,
            ];
        }

        \Log::info('Payload being sent to Maystro Delivery', ['payload' => $payload]);

        $response = Http::withHeaders($headers)->post($apiUrl, $payload);

        if ($response->successful()) {
            $sale->update(['sale_status' => $request['sale_status']]);
                if ($request->redirect_from === 'orders_table') {
        return redirect()->route('business.sales.index')->with('success', __('Sale Status updated successfully.'));
    } elseif ($request->redirect_from === 'confirm_user') {
        return redirect()->route('business.sale-confirme.index')->with('success', __('Sale Status updated successfully.'));
    }
            return response()->json([
                'message' => __('Sale Status updated Successfully'),
                'redirect' => route('business.sales.index'),
            ]);
        } else {
            \Log::error('Shipping API error', [
                'url' => $apiUrl,
                'payload' => $payload,
                'headers' => $headers,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json(['error' => $response->body()], 400);
        }
    }

    public function getNextStatuses($currentStatus)
    {
        $statuses = Sale::getNextStatuses($currentStatus);
        $statusList = [];

        foreach ($statuses as $id) {
            if (isset(Sale::STATUS[$id])) {
                $statusList[] = ['id' => $id, 'name' => Sale::STATUS[$id]['name']];
            }
        }

        return response()->json($statusList);
    }

   public function confirmedOrders()
{
    // Fetch orders where sale_status is 1, 2, 3, 4, or 5
    $orders = Sale::whereIn('sale_status', [1, 2, 3, 4, 5])
        ->orderBy('created_at', 'desc') // Order by the most recent orders
        ->paginate(10); // Paginate the results

   
    return response()->json([
        'orders' => $orders,
    ]);
}

    public function importCsv(Request $request)
    {
        // Validate file type and presence
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Uploaded CSV file is not valid.');
        }

        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);

        if ($header === false || count($header) < 1) {
            fclose($handle);
            return redirect()->back()->with('error', 'CSV file is empty or invalid.');
        }

        $businessId = auth()->user()->business_id;
        $userId = auth()->id();

        $imported = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            \App\Models\Sale::create([
                'business_id'    => $businessId,
                'user_id'        => $userId,
                'order_source_id'=> null,
                'invoiceNumber'  => $data['invoiceNumber'] ?? uniqid('INV-'),
                'customer_name'  => $data['customer_name'] ?? '',
                'customer_email' => $data['customer_email'] ?? null,
                'totalAmount'    => $data['totalAmount'] ?? 0.0,
                'paidAmount'     => $data['paidAmount'] ?? 0.0,
                'dueAmount'      => $data['dueAmount'] ?? 0.0,
                'saleDate'       => $data['saleDate'] ?? now(),
                'sale_status'    => $data['sale_status'] ?? 1,
                'meta'           => json_encode($data),
            ]);
            $imported++;
        }
        fclose($handle);

        return redirect()->back()->with('success', "$imported sales imported successfully from CSV.");
    }

    /**
     * Import sales from Excel file (.xlsx, .xls)
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:4096',
        ]);

        // Use PhpSpreadsheet for Excel import
        try {
            $file = $request->file('excel_file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);

            $header = array_shift($rows);
            $header = array_map('trim', $header);
            $businessId = auth()->user()->business_id;
            $userId = auth()->id();
            $imported = 0;

            foreach ($rows as $row) {
                $data = array_combine($header, $row);
                \App\Models\Sale::create([
                    'business_id'    => $businessId,
                    'user_id'        => $userId,
                    'order_source_id'=> null,
                    'invoiceNumber'  => $data['invoiceNumber'] ?? uniqid('INV-'),
                    'customer_name'  => $data['customer_name'] ?? '',
                    'customer_email' => $data['customer_email'] ?? null,
                    'totalAmount'    => $data['totalAmount'] ?? 0.0,
                    'paidAmount'     => $data['paidAmount'] ?? 0.0,
                    'dueAmount'      => $data['dueAmount'] ?? 0.0,
                    'saleDate'       => $data['saleDate'] ?? now(),
                    'sale_status'    => $data['sale_status'] ?? 1,
                    'meta'           => json_encode($data),
                ]);
                $imported++;
            }
            return redirect()->back()->with('success', "$imported sales imported successfully from Excel.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Excel import failed: ' . $e->getMessage());
        }
    }

    /**
     * Import sales from Google Sheet (by public URL)
     */
    public function importGoogleSheet(Request $request)
    {
        $request->validate([
            'google_sheet_url' => 'required|url',
        ]);
        $sheetUrl = $request->input('google_sheet_url');
        // Convert Google Sheet URL to CSV export URL
        if (preg_match('/\/spreadsheets\/d\/([a-zA-Z0-9-_]+)/', $sheetUrl, $matches)) {
            $sheetId = $matches[1];
            $csvUrl = "https://docs.google.com/spreadsheets/d/$sheetId/export?format=csv";
        } else {
            return redirect()->back()->with('error', 'Invalid Google Sheet URL.');
        }
        try {
            $csv = file_get_contents($csvUrl);
            $lines = explode("\n", $csv);
            $header = str_getcsv(array_shift($lines));
            $header = array_map('trim', $header);
            $businessId = auth()->user()->business_id;
            $userId = auth()->id();
            $imported = 0;
            foreach ($lines as $line) {
                if (trim($line) === '') continue;
                $row = str_getcsv($line);
                $data = array_combine($header, $row);
                \App\Models\Sale::create([
                    'business_id'    => $businessId,
                    'user_id'        => $userId,
                    'order_source_id'=> null,
                    'invoiceNumber'  => $data['invoiceNumber'] ?? uniqid('INV-'),
                    'customer_name'  => $data['customer_name'] ?? '',
                    'customer_email' => $data['customer_email'] ?? null,
                    'totalAmount'    => $data['totalAmount'] ?? 0.0,
                    'paidAmount'     => $data['paidAmount'] ?? 0.0,
                    'dueAmount'      => $data['dueAmount'] ?? 0.0,
                    'saleDate'       => $data['saleDate'] ?? now(),
                    'sale_status'    => $data['sale_status'] ?? 1,
                    'meta'           => json_encode($data),
                ]);
                $imported++;
            }
            return redirect()->back()->with('success', "$imported sales imported successfully from Google Sheet.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Google Sheet import failed: ' . $e->getMessage());
        }
    }
}