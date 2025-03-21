<?php

namespace Modules\Business\App\Exports;

use App\Models\Income;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportIncome implements FromView
{
    public function view(): View
    {
        return view('business::reports.income.excel-csv', [
            'income_reports' => Income::with('category:id,categoryName')->where('business_id', auth()->user()->business_id)->latest()->get()
        ]);
    }
}
