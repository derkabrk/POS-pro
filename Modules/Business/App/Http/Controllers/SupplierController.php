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

            // Use the Sale model to calculate amounts
            $productsSold = Sale::whereHas('details', function ($query) use ($products) {
                $query->whereIn('product_id', $products);
            })->sum('quantity'); // Total products sold

            $productsDelivered = Sale::whereHas('details', function ($query) use ($products) {
                $query->whereIn('product_id', $products)->where('sale_status', 9);
            })->sum('quantity'); // Delivered products

            $productsPaid = Sale::whereHas('details', function ($query) use ($products) {
                $query->whereIn('product_id', $products)->where('sale_status', 11);
            })->sum('quantity'); // Paid products

            $productsCheckout = Sale::whereHas('details', function ($query) use ($products) {
                $query->whereIn('product_id', $products)->where('sale_status', 12);
            })->sum('quantity'); // Products in checkout

            $productsReturned = Sale::whereHas('details', function ($query) use ($products) {
                $query->whereIn('product_id', $products)->where('sale_status', 10);
            })->sum('quantity'); // Returned products

            $totalProducts = $products->count();
            $totalStock = Product::whereIn('id', $products)->sum('productStock'); // Total stock for the supplier
            $pending = Sale::whereHas('details', function ($query) use ($products) {
                $query->whereIn('product_id', $products)->where('sale_status', 'pending');
            })->sum('quantity'); // Pending products
            $available = $totalStock - $pending; // Available stock
            $paid = Sale::whereHas('details', function ($query) use ($products) {
                $query->whereIn('product_id', $products);
            })->sum('paid_amount'); // Total paid amount
            $cashout = Sale::whereHas('details', function ($query) use ($products) {
                $query->whereIn('product_id', $products);
            })->sum('cashout_amount'); // Total cashout amount

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