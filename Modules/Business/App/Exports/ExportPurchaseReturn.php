<?php

namespace Modules\Business\App\Exports;

use App\Models\Purchase;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportPurchaseReturn implements FromView
{
    public function view(): View
    {
        return view('business::reports.purchase-return.excel-csv', [
            'purchases' => Purchase::with([
                'user:id,name',
                'party:id,name,email,phone,type',
                'details:id,purchase_id,product_id,productPurchasePrice,quantities',
                'details.product:id,productName,category_id',
                'details.product.category:id,categoryName',
                'purchaseReturns' => function ($query) {
                    $query->withSum('details as total_return_amount', 'return_amount');
                }
            ])
                ->where('business_id', auth()->user()->business_id)
                ->whereHas('purchaseReturns')
                ->get()
        ]);
    }
}
