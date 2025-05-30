<?php

namespace Modules\Business\App\Exports;

use App\Models\Party;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportDue implements FromView
{
    public function view(): View
    {
        return view('business::reports.due.excel-csv', [
            'due_lists' => Party::where('business_id', auth()->user()->business_id)->where('type', '!=', 'Supplier')->latest()->get()
        ]);
    }
}
