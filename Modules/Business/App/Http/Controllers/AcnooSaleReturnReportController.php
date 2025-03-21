<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleReturnDetails;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportSalesReturn;

class AcnooSaleReturnReportController extends Controller
{
    public function index()
    {
        $total_sale_return = SaleReturnDetails::whereHas('saleReturn', function ($query) {
            $query->whereHas('sale', function ($q) {
                $q->where('business_id', auth()->user()->business_id);
            })->whereDate('return_date', Carbon::today());
        })->sum('return_amount');

        $sales = Sale::with([
            'user:id,name',
            'party:id,name',
            'details',
            'details.product:id,productName,category_id',
            'details.product.category:id,categoryName',
            'saleReturns' => function ($query) {
                $query->withSum('details as total_return_amount', 'return_amount');
            }
        ])
            ->where('business_id', auth()->user()->business_id)
            ->whereHas('saleReturns', function ($query) {
                $query->whereDate('return_date', Carbon::today());
            })
            ->latest()
            ->paginate(20);


        return view('business::reports.sales-return.sale-reports', compact('sales','total_sale_return'));
    }

    public function acnooFilter(Request $request)
    {
        $businessId = auth()->user()->business_id;

        $salesQuery = Sale::with([
            'user:id,name',
            'party:id,name',
            'details',
            'details.product:id,productName,category_id',
            'details.product.category:id,categoryName',
            'saleReturns' => function ($query) {
                $query->withSum('details as total_return_amount', 'return_amount');
            }
        ])
            ->where('business_id', $businessId)
            ->whereHas('saleReturns', function ($query) use ($request) {
                $query->whereDate('return_date', [Carbon::today()->format('Y-m-d'), Carbon::today()->format('Y-m-d')]);
            });

        // Default Date Range
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

        $salesQuery->whereHas('saleReturns', function ($query) use ($startDate, $endDate) {
            $query->whereDate('return_date', [$startDate, $endDate]);
        });

        // Search Filter
        if ($request->filled('search')) {
            $salesQuery->where(function ($query) use ($request) {
                $query->where('invoiceNumber', 'like', '%' . $request->search . '%')
                    ->orWhereHas('party', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $total_sale_return = SaleReturnDetails::whereHas('saleReturn', function ($query) use ($businessId, $startDate, $endDate) {
            $query->whereHas('sale', function ($q) use ($businessId) {
                $q->where('business_id', $businessId);
            })->whereDate('return_date', [$startDate, $endDate]);
        })->sum('return_amount');

        $perPage = $request->input('per_page', 10);
        $sales = $salesQuery->latest()->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.sales-return.datas', compact('sales'))->render(),
                'total_sale_return' => currency_format($total_sale_return, 'icon', 2, business_currency())
            ]);
        }

        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $sales =  Sale::with([
            'user:id,name',
            'party:id,name',
            'details',
            'details.product:id,productName,category_id',
            'details.product.category:id,categoryName',
            'saleReturns' => function ($query) {
                $query->withSum('details as total_return_amount', 'return_amount');
            }
        ])
            ->where('business_id', auth()->user()->business_id)
            ->whereHas('saleReturns')
            ->get();
        $pdf = Pdf::loadView('business::reports.sales-return.pdf', compact('sales'));
        return $pdf->download('sales-return-report.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportSalesReturn, 'sales-return.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportSalesReturn, 'sales-return.csv');
    }
}
