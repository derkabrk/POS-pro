<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Business;
use App\Http\Controllers\Controller;

class DropshipperDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'dropshipper') {
            abort(403, 'Unauthorized');
        }
        $business_id = $user->business_id;
        $products = Product::with(['category', 'brand', 'unit'])
            ->where('business_id', $business_id)
            ->where('productStock', '>', 0)
            ->get();
        $categories = Category::where('business_id', $business_id)->orderBy('categoryName')->get();
        $business = Business::findOrFail($business_id);
        $financier_status = $user->financier_status;
        // Fetch sales/orders for this dropshipper
        $sales = \App\Models\Sale::with('details', 'party')
            ->where('user_id', $user->id)
            ->where('business_id', $business_id)
            ->latest()
            ->take(10)
            ->get();
        return view('business::products.marketplace', compact('products', 'categories', 'business', 'financier_status', 'sales'));
    }
}
