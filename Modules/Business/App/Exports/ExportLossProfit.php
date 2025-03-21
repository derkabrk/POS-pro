<?php

namespace Modules\Business\App\Exports;

use Carbon\Carbon;
use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportLossProfit implements FromView
{
    public function view(): View
    {
        return view('business::reports.loss-profits.excel-csv', [
            'loss_profits' => Sale::with('party:id,name')->where('business_id', auth()->user()->business_id)->whereYear('created_at', Carbon::now()->year)->latest()->get()
        ]);
    }
}
