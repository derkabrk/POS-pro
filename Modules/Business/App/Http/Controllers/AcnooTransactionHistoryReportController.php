<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\DueCollect;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportTransaction;

class AcnooTransactionHistoryReportController extends Controller
{
    public function index()
    {
        $businessId = auth()->user()->business_id;
        $today = Carbon::today()->format('Y-m-d');

        $total_due = DueCollect::where('business_id', $businessId)
            ->whereDate('paymentDate', $today)
            ->sum('totalDue');

        $total_paid = DueCollect::where('business_id', $businessId)
            ->whereDate('paymentDate', $today)
            ->sum('payDueAmount');

        $transactions = DueCollect::where('business_id', $businessId)
            ->whereDate('paymentDate', $today)
            ->with('party:id,name','payment_type:id,name')
            ->latest()
            ->paginate(20);

        return view('business::reports.transaction-history.transaction-reports', compact('transactions', 'total_due', 'total_paid'));
    }

    public function acnooFilter(Request $request)
    {
        $businessId = auth()->user()->business_id;
        $transactionsQuery = DueCollect::with('party:id,name', 'payment_type:id,name')->where('business_id', $businessId);

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

        $transactionsQuery->whereDate('paymentDate', '>=', $startDate)
            ->whereDate('paymentDate', '<=', $endDate);

        // Search Filter
        if ($request->filled('search')) {
            $transactionsQuery->where(function ($query) use ($request) {
                $query->where('paymentType', 'like', '%' . $request->search . '%')
                    ->orWhere('totalDue', 'like', '%' . $request->search . '%')
                    ->orWhere('invoiceNumber', 'like', '%' . $request->search . '%')
                    ->orWhere('payDueAmount', 'like', '%' . $request->search . '%')
                    ->orWhereHas('party', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('payment_type', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $perPage = $request->input('per_page', 10);
        $transactions = $transactionsQuery->latest()->paginate($perPage);

        $total_due = $transactionsQuery->sum('totalDue');
        $total_paid = $transactionsQuery->sum('payDueAmount');

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.transaction-history.datas', compact('transactions'))->render(),
                'total_due' => currency_format($total_due, 'icon', 2, business_currency()),
                'total_paid' => currency_format($total_paid, 'icon', 2, business_currency()),
            ]);
        }

        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $transcations = DueCollect::where('business_id', auth()->user()->business_id)->with('party:id,name,email')->latest()->get();
        $pdf = Pdf::loadView('business::reports.transaction-history.pdf', compact('transcations'));
        return $pdf->download('transcations.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportTransaction, 'transaction-history.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportTransaction, 'transaction-history.csv');
    }
}
