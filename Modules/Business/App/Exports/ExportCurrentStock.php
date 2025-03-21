<?php

namespace Modules\Business\App\Exports;

use App\Models\Party;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportCurrentStock implements FromView
{
    public function view(): View
    {
        return view('business::stocks.excel-csv', [
           'stocks' => Product::where('business_id', auth()->user()->business_id)->latest()->get()
        ]);
    }
}
