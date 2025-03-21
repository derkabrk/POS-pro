<?php

namespace Modules\Business\App\Http\Controllers;

use App\Helpers\HasUploader;
use App\Models\PaymentType;
use App\Models\Vat;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Party;
use App\Models\Product;
use App\Models\Business;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\PurchaseReturn;
use App\Models\PurchaseDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;

class AcnooPurchaseController extends Controller
{
    use HasUploader;

    public function index(Request $request)
    {
        if (!auth()->user()) {
            return redirect()->back()->with('error', 'You have no permission to access.');
        }

        $purchasesWithReturns = PurchaseReturn::where('business_id', auth()->user()->business_id)
            ->pluck('purchase_id')
            ->toArray();

        $query = Purchase::with('details', 'party', 'details.product', 'details.product.category', 'payment_type:id,name')
                            ->where('business_id', auth()->user()->business_id);

        if ($request->today) {
            $query->whereDate('created_at', Carbon::today());
        }

        $purchases = $query->latest()->paginate(20);

        return view('business::purchases.index', compact('purchases', 'purchasesWithReturns'));
    }

    public function acnooFilter(Request $request)
    {
        $purchasesWithReturns = PurchaseReturn::where('business_id', auth()->user()->business_id)
            ->pluck('purchase_id')
            ->toArray();

        $query = Purchase::with('details', 'party', 'details.product', 'details.product.category', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id);

        if ($request->has('today')) {
            $query->whereDate('created_at', Carbon::today());
        }

        $query->when($request->search, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('paymentType', 'like', '%' . $request->search . '%')
                  ->orWhere('invoiceNumber', 'like', '%' . $request->search . '%')
                    ->orWhereHas('party', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('payment_type', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        });

        $purchases = $query->latest()->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::purchases.datas', compact('purchases','purchasesWithReturns'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function productFilter(Request $request)
    {
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
                'product_id' => $total_products == 1 ? $products->first()->id : null,
                'data' => view('business::purchases.product-list', compact('products'))->render(),
                'categories' => view('business::purchases.category-list', compact('categories'))->render(),
                'brands' => view('business::purchases.brand-list', compact('brands'))->render(),
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
            'categories' => view('business::purchases.category-list', compact('categories'))->render(),
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
            'brands' => view('business::purchases.brand-list', compact('brands'))->render(),
        ]);
    }

    public function getInvoice($purchase_id)
    {
        $purchase = Purchase::with('user:id,name', 'party:id,name,phone', 'business:id,phoneNumber,companyName,vat_name,vat_no', 'details:id,productPurchasePrice,quantities,product_id,purchase_id', 'details.product:id,productName', 'payment_type:id,name')
                                ->findOrFail($purchase_id);

        $purchase_returns = PurchaseReturn::with('purchase:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'purchase.party:id,name', 'details','details.purchaseDetail.product:id,productName')
            ->where('business_id', auth()->user()->business_id)
            ->where('purchase_id', $purchase_id)
            ->latest()
            ->get();

        // sum of  return_qty
        $purchase->details = $purchase->details->map(function ($detail) use ($purchase_returns) {
            $return_qty_sum = $purchase_returns->flatMap(function ($return) use ($detail) {
                return $return->details->where('purchaseDetail.id', $detail->id)->pluck('return_qty');
            })->sum();

            $detail->quantities = $detail->quantities + $return_qty_sum;

            return $detail;
        });

        // Calculate total discount based on return quantities and amounts
        $total_discount = 0;
        $product_discounts = [];

        foreach ($purchase_returns as $return) {
            foreach ($return->details as $detail) {
                // Initialize discount tracking for the first occurrence of each purchase_detail_id
                if (!isset($product_discounts[$detail->purchase_detail_id])) {
                    $product_discounts[$detail->purchase_detail_id] = [
                        'return_qty' => 0,
                        'return_amount' => 0,
                        'price' => $detail->purchaseDetail->productPurchasePrice,
                    ];
                }

                // Accumulate return quantities and return amounts
                $product_discounts[$detail->purchase_detail_id]['return_qty'] += $detail->return_qty;
                $product_discounts[$detail->purchase_detail_id]['return_amount'] += $detail->return_amount;
            }
        }

        // Calculate the total discount for each returned product
        foreach ($product_discounts as $data) {
            $product_price = $data['price'] * $data['return_qty'];
            $discount = $product_price - $data['return_amount'];

            $total_discount += $discount;
        }

        return view('business::purchases.invoice', compact('purchase', 'purchase_returns', 'total_discount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Clears all cart items
        Cart::destroy();

        $suppliers = Party::where('type', 'Supplier')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();
        $products = Product::with('category:id,categoryName','unit:id,unitName', 'brand:id,brandName')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();

        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'purchase');
        $categories = Category::where('business_id', auth()->user()->business_id)->latest()->get();
        $brands = Brand::where('business_id', auth()->user()->business_id)->latest()->get();
        $vats = Vat::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $payment_types = PaymentType::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();


        // Generate a unique invoice number
        $purchase_id = (Purchase::max('id') ?? 0) + 1;
        $invoice_no = 'P-' . str_pad($purchase_id, 5, '0', STR_PAD_LEFT);

        return view('business::purchases.create', compact('suppliers', 'products', 'cart_contents', 'invoice_no', 'categories', 'brands', 'vats', 'payment_types'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'party_id' => 'required|exists:parties,id',
            'invoiceNumber' => 'required|string',
            'receive_amount' => 'nullable|numeric',
            'payment_type_id' => 'required|exists:payment_types,id',
            'vat_id' => 'nullable|exists:vats,id',
            'discountAmount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:flat,percent',
            'shipping_charge' => 'nullable|numeric',
            'purchaseDate' => 'nullable|date',
        ]);

        $business_id = auth()->user()->business_id;

        $carts = Cart::content()->filter(fn($item) => $item->options->type == 'purchase');

        if ($carts->count() < 1) {
            return response()->json(['message' => __('Cart is empty. Add items first!')], 400);
        }

        DB::beginTransaction();
        try {
            // Subtotal
            $subtotal = $carts->sum(function ($cartItem) {
                return (float)$cartItem->subtotal;
            });

            // VAT
            $vat = Vat::find($request->vat_id);
            $vatAmount = 0;
            if ($vat){
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

            if ($dueAmount > 0) {
                $party = Party::findOrFail($request->party_id);
                $party->update([
                    'due' => $party->due + $dueAmount
                ]);
            }

            // Update business balance
            $business = Business::findOrFail(auth()->user()->business_id);
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance - $paidAmount,
            ]);

            $purchase = Purchase::create($request->except('discountAmount','discount_type', 'discount_percent','shipping_charge') + [
                    'business_id' => auth()->user()->business_id,
                    'user_id' => auth()->id(),
                    'vat_id' => $request->vat_id,
                    'vat_amount' => $vatAmount,
                    'discountAmount' => $discountAmount,
                    'discount_type' => $request->discount_type ?? 'flat',
                    'discount_percent' => $request->discount_type == 'percent' ? $request->discountAmount : 0,
                    'totalAmount' => $totalAmount,
                    'paidAmount' => $paidAmount,
                    'dueAmount' => $dueAmount,
                    'payment_type_id' => $request->payment_type_id,
                    'shipping_charge' => $shippingCharge,
                    'purchaseDate' => $request->purchaseDate ?? now(),
                    'isPaid' => $dueAmount > 0 ? 0 : 1,
                ]);
            $purchaseDetailsData = [];
            foreach ($carts as $cartItem) {
                $purchaseDetailsData[] = [
                    'purchase_id' => $purchase->id,
                    'product_id' => $cartItem->id,
                    'quantities' => $cartItem->qty,
                    'productPurchasePrice' => $cartItem->price,
                    'productDealerPrice' => $cartItem->options['dealer_price'],
                    'productSalePrice' => $cartItem->options['sales_price'],
                    'productWholeSalePrice' => $cartItem->options['whole_sale_price'],
                ];
            }

            PurchaseDetails::insert($purchaseDetailsData);

            foreach ($purchaseDetailsData as $item) {
                $product = Product::findOrFail($item['product_id']);
                $product->update([
                    'productStock' => $product->productStock + (int)$item['quantities'] ?? 0,
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

            // Remove of all Purchases cart
            foreach ($carts as $cartItem) {
                Cart::remove($cartItem->rowId);
            }

            sendNotifyToUser($purchase->id, route('business.purchases.index', ['id' => $purchase->id]), __('New Purchase created.'), $business_id);

            DB::commit();


            return response()->json([
                'message' => __('Purchase created successfully.'),
                'redirect' => route('business.purchases.index'),
                'secondary_redirect_url' => route('business.purchases.invoice', $purchase->id),

            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Somethings went wrong!')], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Clears all cart items
        Cart::destroy();

        $purchase = Purchase::with('details','details.product','details.product.unit', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->findOrFail($id);

        $suppliers = Party::where('type', 'Supplier')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();

        $products = Product::with('category:id,categoryName','unit:id,unitName', 'brand:id,brandName')
            ->where('business_id', auth()->user()->business_id)
            ->latest()
            ->get();

        $categories = Category::where('business_id', auth()->user()->business_id)->latest()->get();
        $brands = Brand::where('business_id', auth()->user()->business_id)->latest()->get();
        $vats = Vat::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $payment_types = PaymentType::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();


        // Add purchase details to the cart
        foreach ($purchase->details as $detail) {
            // Add to cart
            Cart::add([
                'id' => $detail->product_id,
                'name' => $detail->product->productName ?? '',
                'qty' => $detail->quantities,
                'price' => $detail->productPurchasePrice,
                'options' => [
                    'type' => 'purchase',
                    'product_code' => $detail->product->productCode ?? '',
                    'product_unit_id' => $detail->product->unit_id ?? null,
                    'product_unit_name' => $detail->product->unit->unitName ?? '',
                    'product_image' => $detail->product->productPicture ?? '',
                    'sales_price' => $detail->productSalePrice,
                    'whole_sale_price' => $detail->productWholeSalePrice,
                    'dealer_price' => $detail->productDealerPrice,
                ],
            ]);
        }

        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'purchase');

        return view('business::purchases.edit', compact('purchase','suppliers', 'products', 'cart_contents', 'categories', 'brands', 'vats', 'payment_types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'party_id' => 'required|exists:parties,id',
            'invoiceNumber' => 'required|string',
            'receive_amount' => 'nullable|numeric',
            'payment_type_id' => 'required|exists:payment_types,id',
            'vat_id' => 'nullable|exists:vats,id',
            'discountAmount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:flat,percent',
            'shipping_charge' => 'nullable|numeric',
            'purchaseDate' => 'nullable|date',
        ]);

        $business_id = auth()->user()->business_id;

        $carts = Cart::content()->filter(fn($item) => $item->options->type === 'purchase');

        if ($carts->count() < 1) {
            return response()->json(['message' => __('Cart is empty. Add items first!')], 400);
        }

        DB::beginTransaction();
        try {
            $purchase = Purchase::with('details')->findOrFail($id);

            // Calculate amounts
            $subtotal = $carts->sum(fn($cartItem) => (float)$cartItem->subtotal);

            // VAT
            $vat = Vat::find($request->vat_id);
            $vatAmount = 0;
            if ($vat){
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

            // Adjust party due if necessary
            $party = Party::findOrFail($request->party_id);
            $party->update([
                'due' => $party->due - $purchase->dueAmount + $dueAmount,
            ]);

            // Update business balance
            $business = Business::findOrFail(auth()->user()->business_id);
            $business->update([
                'remainingShopBalance' => $business->remainingShopBalance + $purchase->paidAmount - $paidAmount,
            ]);

            // Update purchase details
            $purchase->update($request->except('discountAmount','discount_type', 'discount_percent', 'shipping_charge') + [
                    'business_id' => auth()->user()->business_id,
                    'user_id' => auth()->id(),
                    'vat_id' => $request->vat_id,
                    'vat_amount' => $vatAmount,
                    'discountAmount' => $discountAmount,
                    'discount_type' => $request->discount_type ?? 'flat',
                    'discount_percent' => $request->discount_type == 'percent' ? $request->discountAmount : 0,
                    'totalAmount' => $totalAmount,
                    'paidAmount' => $paidAmount,
                    'dueAmount' => $dueAmount,
                    'payment_type_id' => $request->payment_type_id,
                    'shipping_charge' => $shippingCharge,
                    'purchaseDate' => $request->purchaseDate ?? now(),
                    'isPaid' => $dueAmount > 0 ? 0 : 1,
                ]);

            // Revert previous stock changes
            foreach ($purchase->details as $detail) {
                $product = Product::findOrFail($detail->product_id);
                $product->update([
                    'productStock' => $product->productStock - $detail->quantities,
                ]);
            }

            // Delete existing purchase details
            $purchase->details()->delete();

            // Insert updated purchase details and adjust stock
            $purchaseDetailsData = [];
            foreach ($carts as $cartItem) {
                $purchaseDetailsData[] = [
                    'purchase_id' => $purchase->id,
                    'product_id' => $cartItem->id,
                    'quantities' => $cartItem->qty,
                    'productPurchasePrice' => $cartItem->price,
                    'productDealerPrice' => $cartItem->options['dealer_price'],
                    'productSalePrice' => $cartItem->options['sales_price'],
                    'productWholeSalePrice' => $cartItem->options['whole_sale_price'],
                ];
            }

            PurchaseDetails::insert($purchaseDetailsData);

            foreach ($purchaseDetailsData as $item) {
                $product = Product::findOrFail($item['product_id']);
                $product->update([
                    'productStock' => $product->productStock + (int)$item['quantities'] ?? 0,
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

            // Clear the cart
            foreach ($carts as $cartItem) {
                Cart::remove($cartItem->rowId);
            }

            sendNotifyToUser($purchase->id, route('business.purchases.index', ['id' => $purchase->id]), __('Purchase has been updated.'), $business_id);

            DB::commit();
            return response()->json([
                'message' => __('Purchase updated successfully.'),
                'redirect' => route('business.purchases.index'),
                'secondary_redirect_url' => route('business.purchases.invoice', $purchase->id),
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::findOrFail($id);

            foreach ($purchase->details as $detail) {
                $product = Product::findOrFail($detail->product_id);
                $product->update([
                    'productStock' => $product->productStock - $detail->quantities
                ]);
            }
            if ($purchase->party_id) {
                $party = Party::findOrFail($purchase->party_id);
                $party->update([
                    'due' => $party->due - $purchase->dueAmount
                ]);
            }

            sendNotifyToUser($purchase->id, route('business.purchases.index', ['id' => $purchase->id]), __('Purchase has been deleted.'), $purchase->business_id);


            $purchase->delete();

            // Clears all cart items
            Cart::destroy();

            DB::commit();

            return response()->json([
                'message' => __('Purchase deleted successfully.'),
                'redirect' => route('business.purchases.index')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }

    public function showPurchaseCart()
    {
        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'purchase');
        return view('business::purchases.cart-list', compact('cart_contents'));
    }

    public function getCartData()
    {
        $cart_contents = Cart::content()->filter(fn($item) => $item->options->type == 'purchase');
        $data['sub_total'] = 0;

        foreach ($cart_contents as $cart) {
            $data['sub_total'] += $cart->price;
        }
        $data['sub_total'] = currency_format($data['sub_total'], 'icon', 2, business_currency());

        return response()->json($data);
    }

    public function deleteAll(Request $request)
    {
        DB::beginTransaction();

        try {
            $purchases = Purchase::whereIn('id', $request->ids)->get();

            foreach ($purchases as $purchase) {
                foreach ($purchase->details as $detail) {
                    $product = Product::findOrFail($detail->product_id);
                    $product->update([
                        'productStock' => $product->productStock - $detail->quantities
                    ]);
                }

                if ($purchase->party_id) {
                    $party = Party::findOrFail($purchase->party_id);
                    $party->update([
                        'due' => $party->due - $purchase->dueAmount
                    ]);
                }

                sendNotifyToUser($purchase->id, route('business.purchases.index', ['id' => $purchase->id]), __('Purchases has been deleted.'), $purchase->business_id);

                $purchase->delete();
            }

            // Clears all cart items
            Cart::destroy();

            DB::commit();

            return response()->json([
                'message' => __('Selected purchases deleted successfully.'),
                'redirect' => route('business.purchases.index')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }

    public function generatePDF($purchase_id)
    {
        $purchase = Purchase::with('user:id,name', 'party:id,name,phone', 'business:id,phoneNumber,companyName,vat_name,vat_no', 'details:id,productPurchasePrice,quantities,product_id,purchase_id', 'details.product:id,productName', 'payment_type:id,name')->findOrFail($purchase_id);

        $purchase_returns = PurchaseReturn::with('purchase:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'purchase.party:id,name', 'details','details.purchaseDetail.product:id,productName')
            ->where('business_id', auth()->user()->business_id)
            ->where('purchase_id', $purchase_id)
            ->latest()
            ->get();

        $purchase->details = $purchase->details->map(function ($detail) use ($purchase_returns) {
            $return_qty_sum = $purchase_returns->flatMap(function ($return) use ($detail) {
                return $return->details->where('purchaseDetail.id', $detail->id)->pluck('return_qty');
            })->sum();

            $detail->quantities = $detail->quantities + $return_qty_sum;

            return $detail;
        });

        $pdf = Pdf::loadView('business::purchases.pdf', compact('purchase','purchase_returns'));
        return $pdf->download('purchases.pdf');
    }

    public function sendMail($purchase_id)
    {
        $purchase = Purchase::with('user:id,name', 'party:id,name,phone', 'business:id,phoneNumber,companyName,vat_name,vat_no', 'details:id,productPurchasePrice,quantities,product_id,purchase_id', 'details.product:id,productName', 'payment_type:id,name')
                                ->findOrFail($purchase_id);

        $purchase_returns = PurchaseReturn::with('purchase:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'purchase.party:id,name', 'details','details.purchaseDetail.product:id,productName')
            ->where('business_id', auth()->user()->business_id)
            ->where('purchase_id', $purchase_id)
            ->latest()
            ->get();

        $purchase->details = $purchase->details->map(function ($detail) use ($purchase_returns) {
            $return_qty_sum = $purchase_returns->flatMap(function ($return) use ($detail) {
                return $return->details->where('purchaseDetail.id', $detail->id)->pluck('return_qty');
            })->sum();

            $detail->quantities = $detail->quantities + $return_qty_sum;

            return $detail;
        });

        $pdf = Pdf::loadView('business::purchases.pdf', compact('purchase','purchase_returns'));


    // Send email with PDF attachment
    Mail::raw('Please find attached your Purchase invoice.', function ($message) use ($pdf) {
        $message->to(auth()->user()->email)
                ->subject('Purchase Invoice')
                ->attachData($pdf->output(), 'purchase-invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
            });

        return response()->json([
            'message' => __('Email Sent Successfully.'),
            'redirect' => route('business.purchases.index'),
        ]);

    }

    public function createSupplier(Request $request)
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
            'message'   => __('Supplier created successfully'),
            'redirect'  => route('business.purchases.create')
        ]);

    }

}
