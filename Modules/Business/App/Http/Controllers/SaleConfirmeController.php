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
        $orders = Sale::with([
                'user:id,name',
                'party:id,name',
                'details',
                'details.product:id,productName,category_id',
                'details.product.category:id,categoryName',
                'saleReturns' => function ($query) {
                    $query->withSum('details as total_return_amount', 'return_amount');
                }
            ])
            ->where('business_id', auth()->user()->business_id)
            ->whereIn('sale_status', [1, 2, 3, 4, 5])
            ->latest()
            ->paginate(20);

        return view('business::sale-confirmed.index', compact('orders'));
    }
}
