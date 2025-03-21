<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportIncome;

class AcnooIncomeReportController extends Controller
{
    public function index()
    {
        $businessId = auth()->user()->business_id;
        $today = Carbon::today()->format('Y-m-d');

        $total_income = Income::where('business_id', $businessId)
            ->whereDate('incomeDate', $today)
            ->sum('amount');

        $income_reports = Income::with('category:id,categoryName', 'payment_type:id,name')
            ->where('business_id', $businessId)
            ->whereDate('incomeDate', $today)
            ->latest()
            ->paginate(20);

        return view('business::reports.income.income-reports', compact('income_reports', 'total_income'));
    }

    public function acnooFilter(Request $request)
    {
        $businessId = auth()->user()->business_id;
        $incomeQuery = Income::with('category:id,categoryName', 'payment_type:id,name')
            ->where('business_id', $businessId);

        // Default to today
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

        $incomeQuery->whereDate('incomeDate', '>=', $startDate)
            ->whereDate('incomeDate', '<=', $endDate);

        // Search Filter
        if ($request->filled('search')) {
            $incomeQuery->where(function ($query) use ($request) {
                $query->where('incomeFor', 'like', '%' . $request->search . '%')
                    ->orWhere('paymentType', 'like', '%' . $request->search . '%')
                    ->orWhere('amount', 'like', '%' . $request->search . '%')
                    ->orWhere('referenceNo', 'like', '%' . $request->search . '%')
                    ->orWhereHas('category', function ($q) use ($request) {
                        $q->where('categoryName', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('payment_type', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $perPage = $request->input('per_page', 10);
        $income_reports = $incomeQuery->latest()->paginate($perPage);

        $total_income = $incomeQuery->sum('amount');

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.income.datas', compact('income_reports'))->render(),
                'total_income' => currency_format($total_income, 'icon', 2, business_currency())
            ]);
        }

        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $income_reports = Income::with('category:id,categoryName', 'payment_type:id,name')->where('business_id', auth()->user()->business_id)->latest()->get();
        $pdf = Pdf::loadView('business::reports.income.pdf', compact('income_reports'));
        return $pdf->download('income.report.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportIncome, 'income.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportIncome, 'income.csv');
    }
}
