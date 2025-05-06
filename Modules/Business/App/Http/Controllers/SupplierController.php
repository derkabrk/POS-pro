<?php
namespace Modules\Business\App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Party;
use App\Models\Product;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        // Fetch suppliers
        $suppliers = Party::where('type', 'Supplier')->get();

        // Calculate supplier data
        $suppliersData = $suppliers->map(function ($supplier) {
            $products = Product::where('supplier_id', $supplier->id)->get();

            $totalProducts = $products->count();
            $totalStock = $products->sum('productStock');
            $productsSold = $products->sum('sold_quantity'); // Assuming you have a `sold_quantity` field
            $productsDelivered = $products->sum('delivered_quantity'); // Assuming you have a `delivered_quantity` field
            $productsPaid = $products->sum('paid_quantity'); // Assuming you have a `paid_quantity` field
            $productsCheckout = $products->sum('checkout_quantity'); // Assuming you have a `checkout_quantity` field
            $productsReturned = $products->sum('returned_quantity'); // Assuming you have a `returned_quantity` field

            $pending = $products->sum('pending_quantity'); // Assuming you have a `pending_quantity` field
            $available = $totalStock - $pending;
            $paid = $products->sum('paid_amount'); // Assuming you have a `paid_amount` field
            $cashout = $products->sum('cashout_amount'); // Assuming you have a `cashout_amount` field

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

        return view('suppliers.index', compact('suppliersData'));
    }
}