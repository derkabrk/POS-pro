<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportExpense;

class AcnooExpenseReportController extends Controller
{
    public function index()
    {
        $businessId = auth()->user()->business_id;

        $total_expense = Expense::where('business_id', $businessId)
            ->whereDate('expenseDate', Carbon::today()->format('Y-m-d'))
            ->sum('amount');

        $expense_reports = Expense::with('category:id,categoryName', 'payment_type:id,name')
            ->where('business_id', $businessId)
            ->whereDate('expenseDate', Carbon::today()->format('Y-m-d'))
            ->latest()
            ->paginate(20);

        return view('business::reports.expense.expense-reports', compact('expense_reports', 'total_expense'));
    }

    public function acnooFilter(Request $request)
    {
        $businessId = auth()->user()->business_id;

        $expenseQuery = Expense::with('category:id,categoryName', 'payment_type:id,name')
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

        $expenseQuery->whereDate('expenseDate', '>=', $startDate)
            ->whereDate('expenseDate', '<=', $endDate);

        // Search Filter
        if ($request->filled('search')) {
            $expenseQuery->where(function ($query) use ($request) {
                $query->where('expanseFor', 'like', '%' . $request->search . '%')
                    ->orWhere('paymentType', 'like', '%' . $request->search . '%')
                    ->orWhere('referenceNo', 'like', '%' . $request->search . '%')
                    ->orWhere('amount', 'like', '%' . $request->search . '%')
                    ->orWhereHas('category', function ($q) use ($request) {
                        $q->where('categoryName', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('payment_type', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $total_expense = Expense::where('business_id', $businessId)
            ->whereDate('expenseDate', '>=', $startDate)
            ->whereDate('expenseDate', '<=', $endDate)
            ->sum('amount');

        $perPage = $request->input('per_page', 10);
        $expense_reports = $expenseQuery->latest()->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.expense.datas', compact('expense_reports'))->render(),
                'total_expense' => currency_format($total_expense, 'icon', 2, business_currency())
            ]);
        }

        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $expense_reports = Expense::with('category:id,categoryName', 'payment_type:id,name')->where('business_id', auth()->user()->business_id)->latest()->get();
        $pdf = Pdf::loadView('business::reports.expense.pdf', compact('expense_reports'));
        return $pdf->download('expense.report.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportExpense, 'expense.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportExpense, 'expense.csv');
    }
}
