<?php
namespace Modules\Business\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Party;
use App\Models\Product;
use App\Models\Sale; // Import the Sale model
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        // Fetch suppliers with pagination
        $suppliers = Party::where('type', 'Supplier')->paginate(10); // Adjust the per-page value as needed

        // Calculate supplier data
        $suppliersData = $suppliers->map(function ($supplier) {
            $products = Product::where('supplier_id', $supplier->id)->pluck('id'); // Get product IDs for the supplier

            // Use the SaleDetails model to calculate amounts correctly
            $productsSold = \App\Models\SaleDetails::whereIn('product_id', $products)->sum('quantities'); // Total products sold

            $productsDelivered = \App\Models\SaleDetails::whereIn('product_id', $products)
                ->whereHas('saleRelation', function ($q) { $q->where('sale_status', 9); })
                ->sum('quantities'); // Delivered products

            $productsPaid = \App\Models\SaleDetails::whereIn('product_id', $products)
                ->whereHas('saleRelation', function ($q) { $q->where('sale_status', 11); })
                ->sum('quantities'); // Paid products

            $productsCheckout = \App\Models\SaleDetails::whereIn('product_id', $products)
                ->whereHas('saleRelation', function ($q) { $q->where('sale_status', 12); })
                ->sum('quantities'); // Products in checkout

            $productsReturned = \App\Models\SaleDetails::whereIn('product_id', $products)
                ->whereHas('saleRelation', function ($q) { $q->where('sale_status', 10); })
                ->sum('quantities'); // Returned products

            $totalProducts = $products->count();
            $totalStock = Product::whereIn('id', $products)->sum('productStock'); // Total stock for the supplier
            $pending = \App\Models\SaleDetails::whereIn('product_id', $products)
                ->whereHas('saleRelation', function ($q) { $q->where('sale_status', 1); })
                ->sum('quantities'); // Pending products
            $available = $totalStock - $pending; // Available stock
            $paid = \App\Models\SaleDetails::whereIn('product_id', $products)
                ->whereHas('saleRelation', function ($q) { $q->where('sale_status', 11); })
                ->sum('price'); // Total paid amount (sum of price for paid sales)
            $cashout = \App\Models\SaleDetails::whereIn('product_id', $products)
                ->whereHas('saleRelation', function ($q) { $q->where('sale_status', 12); })
                ->sum('price'); // Total cashout amount (sum of price for cashout sales)

            return [
                'supplier' => $supplier,
                'totalProducts' => $totalProducts,
                'totalStock' => $totalStock,
                'productsSold' => $productsSold,
                'productsDelivered' => $productsDelivered,
                'productsPaid' => $productsPaid,
                'productsCheckout' => $productsCheckout,
                'productsReturned' => $productsReturned,
                'pending' => $pending,
                'available' => $available,
                'paid' => $paid,
                'cashout' => $cashout,
            ];
        });

        return view('business::suppliers.index', compact('suppliers', 'suppliersData'));
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_details', 'sale_id', 'product_id')
                    ->withPivot('quantity');
    }
}