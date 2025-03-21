<?php

namespace Modules\Business\App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportExpiredProduct implements FromView
{
    public function view(): View
    {
        return view('business::expired-products.excel-csv', [
            'expired_products' => Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')->where('business_id', auth()->user()->business_id)->where('expire_date', '<=', date('Y-m-d'))->latest()->get()
        ]);
    }
}
