<?php

namespace Modules\Business\App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportLossProfit;

class AcnooLossProfitReportController extends Controller
{
    public function index()
    {
        $businessId = auth()->user()->business_id;
        $today = Carbon::today()->format('Y-m-d');

        $loss = Sale::where('business_id', $businessId)
            ->whereDate('created_at', $today)
            ->where('lossProfit', '<=', 0)
            ->selectRaw('SUM(ABS(lossProfit)) as total_loss')
            ->value('total_loss');

        $profit = Sale::where('business_id', $businessId)
            ->whereDate('created_at', $today)
            ->where('lossProfit', '>', 0)
            ->sum('lossProfit');

        $total_sale_count = Sale::where('business_id', $businessId)
            ->whereDate('created_at', $today)
            ->count();

        $loss_profits = Sale::with('party:id,name')
            ->where('business_id', $businessId)
            ->whereDate('created_at', $today)
            ->latest()
            ->paginate(20);

        return view('business::reports.loss-profits.loss-profit-reports', compact('loss_profits', 'profit', 'loss', 'total_sale_count'));
    }

    public function acnooFilter(Request $request)
    {
        $salesQuery = Sale::with('party:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->when($request->custom_days, function ($query) use ($request) {
                $startDate = Carbon::today()->format('Y-m-d');
                $endDate = Carbon::today()->format('Y-m-d');

                if ($request->custom_days === 'yesterday') {
                    $startDate = Carbon::yesterday()->format('Y-m-d');
                    $endDate = Carbon::yesterday()->format('Y-m-d');
                } elseif ($request->custom_days === 'last_seven_days') {
                    $startDate = Carbon::today()->subDays(6)->format('Y-m-d');
                } elseif ($request->custom_days === 'last_thirty_days') {
                    $startDate = Carbon::today()->subDays(29)->format('Y-m-d');
                } elseif ($request->custom_days === 'current_month') {
                    $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                    $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
                } elseif ($request->custom_days === 'last_month') {
                    $startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
                    $endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                } elseif ($request->custom_days === 'current_year') {
                    $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
                    $endDate = Carbon::now()->endOfYear()->format('Y-m-d');
                } elseif ($request->custom_days === 'custom_date' && $request->from_date && $request->to_date) {
                    $startDate = Carbon::parse($request->from_date)->format('Y-m-d');
                    $endDate = Carbon::parse($request->to_date)->format('Y-m-d');
                }

                $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('lossProfit', 'like', '%' . $request->search . '%')
                        ->orWhere('totalAmount', 'like', '%' . $request->search . '%')
                        ->orWhere('invoiceNumber', 'like', '%' . $request->search . '%')
                        ->orWhereHas('party', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->search . '%');
                        });
                });
            });

        $loss_profits = $salesQuery->latest()->paginate($request->per_page ?? 10);

        $loss = $salesQuery->where('lossProfit', '<=', 0)
            ->get()
            ->sum(function ($sale) {
                return abs($sale->lossProfit);
            });

        $profit = $salesQuery->where('lossProfit', '>', 0)->sum('lossProfit');
        $total_sale_count = $salesQuery->count();

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.loss-profits.datas', compact('loss_profits'))->render(),
                'total_loss' => currency_format($loss, 'icon', 2, business_currency()),
                'total_profit' => currency_format($profit, 'icon', 2, business_currency()),
                'total_sale_count' => $total_sale_count,
            ]);
        }

        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $loss_profits = Sale::with('party:id,name')->where('business_id', auth()->user()->business_id)->whereYear('created_at', Carbon::now()->year)->latest()->get();
        $pdf = Pdf::loadView('business::reports.loss-profits.pdf', compact('loss_profits'));
        return $pdf->download('loss-profits.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportLossProfit, 'loss-profit.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportLossProfit, 'loss-profit.csv');
    }
}
