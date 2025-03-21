<?php

namespace Modules\Business\App\Exports;

use App\Models\DueCollect;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportTransaction implements FromView
{
    public function view(): View
    {
        return view('business::reports.transaction-history.excel-csv', [
            'transcations' => DueCollect::where('business_id', auth()->user()->business_id)->with('party:id,name,email')->latest()->get()
        ]);
    }
}
