<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Support\Carbon;
use Modules\Business\App\Exports\ExportExcelCsv;
use App\Models\Sale;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AcnooSaleReportController extends Controller
{
    public function index()
    {
        $businessId = auth()->user()->business_id;

        $total_sale = Sale::where('business_id', $businessId)
            ->whereDate('created_at', Carbon::today())
            ->sum('totalAmount');

        $sales = Sale::with('user:id,name', 'party:id,name,email,phone,type', 'business:id,companyName', 'payment_type:id,name')
            ->where('business_id', $businessId)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->paginate(20);

        return view('business::reports.sales.sale-reports', compact('sales','total_sale'));
    }

    public function acnooFilter(Request $request)
    {
        $businessId = auth()->user()->business_id;
        $salesQuery = Sale::with('user:id,name', 'party:id,name,email,phone,type', 'payment_type:id,name')
            ->where('business_id', $businessId);

        // Default to today
        $startDate = Carbon::today()->format('Y-m-d');
        $endDate = Carbon::today()->format('Y-m-d');

        if ($request->custom_days === 'yesterday') {
            $startDate = Carbon::yesterday()->format('Y-m-d');
            $endDate = Carbon::yesterday()->format('Y-m-d');
        } elseif ($request->custom_days === 'last_seven_days') {
            $startDate = Carbon::today()->subDays(6)->format('Y-m-d');
        }elseif ($request->custom_days === 'last_thirty_days') {
            $startDate = Carbon::today()->subDays(29)->format('Y-m-d');
        }
        elseif ($request->custom_days === 'current_month') {
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        }elseif ($request->custom_days === 'last_month') {
            $startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        }
        elseif ($request->custom_days === 'current_year') {
            $startDate = Carbon::now()->startOfYear()->format('Y-m-d');
            $endDate = Carbon::now()->endOfYear()->format('Y-m-d');
        } elseif ($request->custom_days === 'custom_date' && $request->from_date && $request->to_date) {
            $startDate = Carbon::parse($request->from_date)->format('Y-m-d');
            $endDate = Carbon::parse($request->to_date)->format('Y-m-d');
        }

        $salesQuery->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        // Search Filter
        if ($request->filled('search')) {
            $salesQuery->where(function ($query) use ($request) {
                $query->where('paymentType', 'like', '%' . $request->search . '%')
                    ->orWhere('invoiceNumber', 'like', '%' . $request->search . '%')
                    ->orWhereHas('party', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('payment_type', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $perPage = $request->input('per_page', 10);
        $sales = $salesQuery->latest()->paginate($perPage);

        $total_sale = $salesQuery->sum('totalAmount');


        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.sales.datas', compact('sales'))->render(),
                'total_sale' => currency_format($total_sale, 'icon', 2, business_currency())
            ]);
        }

        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $sales = Sale::with('user:id,name', 'party:id,name,email,phone,type', 'payment_type:id,name')->where('business_id', auth()->user()->business_id)->latest()->get();
        $pdf = Pdf::loadView('business::reports.sales.pdf', compact('sales'));
        return $pdf->download('reports.sales.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportExcelCsv, 'sale.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportExcelCsv, 'sale.csv');
    }
}
