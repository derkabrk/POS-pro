<?php

namespace Modules\Business\App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportCurrentLossProfit;

class AcnooLossProfitController extends Controller
{
    public function index()
    {
        $profit = Sale::where('business_id', auth()->user()->business_id)->whereYear('created_at', Carbon::now()->year)->where('lossProfit', '>', 0)->sum('lossProfit');
        $loss = Sale::where('business_id', auth()->user()->business_id)->whereYear('created_at', Carbon::now()->year)->where('lossProfit', '<=', 0)->selectRaw('SUM(ABS(lossProfit)) as total_loss')->value('total_loss');
        $total_sale = Sale::where('business_id', auth()->user()->business_id)->whereYear('created_at', Carbon::now()->year)->count();
        $loss_profits = Sale::with('party:id,name')->where('business_id', auth()->user()->business_id)->whereYear('created_at', Carbon::now()->year)->latest()->paginate(20);
        return view('business::loss-profits.index', compact('loss_profits', 'profit', 'loss','total_sale'));
    }

    public function acnooFilter(Request $request)
    {
        $loss_profits = Sale::with('party:id,name')
            ->where('business_id', auth()->user()->business_id)->whereYear('created_at', Carbon::now()->year)
            ->when($request->from_date && $request->to_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->from_date, $request->to_date]);
            })
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('lossProfit', 'like', '%' . $request->search . '%')
                      ->orwhere('invoiceNumber', 'like', '%' . $request->search . '%')
                        ->orWhereHas('party', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->search . '%')
                               ->orwhere('totalAmount', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::loss-profits.datas', compact('loss_profits'))->render()
            ]);
        }

        return redirect(url()->previous());
    }


    public function generatePDF(Request $request)
    {
        $loss_profits = Sale::with('party:id,name')->where('business_id', auth()->user()->business_id)->whereYear('created_at', Carbon::now()->year)->latest()->get();
        $pdf = Pdf::loadView('business::loss-profits.pdf', compact('loss_profits'));
        return $pdf->download('loss-profits.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportCurrentLossProfit, 'loss-profits.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportCurrentLossProfit, 'loss-profits.csv');
    }
}
