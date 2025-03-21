<?php

namespace Modules\Business\App\Exports;

use App\Models\Sale;
use App\Models\SaleReturnDetails;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportSalesReturn implements FromView
{
    public function view(): View
    {
        return view('business::reports.sales-return.excel-csv', [
            'sales' => Sale::with(['user:id,name', 'party:id,name', 'details', 'details.product:id,productName,category_id', 'details.product.category:id,categoryName',
            'saleReturns' => function($query) {
                $query->withSum('details as total_return_amount', 'return_amount');
            }
        ])
        ->where('business_id', auth()->user()->business_id)
        ->whereHas('saleReturns')
        ->get()
        ]);
    }
}
