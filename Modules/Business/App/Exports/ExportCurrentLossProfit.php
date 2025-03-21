<?php

namespace Modules\Business\App\Exports;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Party;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportCurrentLossProfit implements FromView
{
    public function view(): View
    {
        return view('business::loss-profits.excel-csv', [
           'loss_profits' => Sale::with('party:id,name')->where('business_id', auth()->user()->business_id)->whereYear('created_at', Carbon::now()->year)->latest()->get()
        ]);
    }
}
