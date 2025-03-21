<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseReturnDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportPurchaseReturn;

class AcnooPurchaseReturnReportController extends Controller
{
    public function index()
    {
        $businessId = auth()->user()->business_id;
        $today = Carbon::today()->format('Y-m-d');

        $total_purchase_return = PurchaseReturnDetail::whereHas('purchaseReturn', function ($query) use ($businessId, $today) {
            $query->whereHas('purchase', function ($q) use ($businessId) {
                $q->where('business_id', $businessId);
            })->whereDate('return_date', $today);
        })->sum('return_amount');

        $purchases = Purchase::with([
            'user:id,name',
            'party:id,name,email,phone,type',
            'details:id,purchase_id,product_id,productPurchasePrice,quantities',
            'details.product:id,productName,category_id',
            'details.product.category:id,categoryName',
            'purchaseReturns' => function ($query) {
                $query->withSum('details as total_return_amount', 'return_amount');
            }
        ])
            ->where('business_id', $businessId)
            ->whereHas('purchaseReturns', function ($query) use ($today) {
                $query->whereDate('return_date', $today);
            })
            ->latest()
            ->paginate(20);

        return view('business::reports.purchase-return.purchase-reports', compact('purchases', 'total_purchase_return'));
    }

    public function acnooFilter(Request $request)
    {
        $businessId = auth()->user()->business_id;

        // Default Date Range: Today
        $startDate = Carbon::today()->format('Y-m-d');
        $endDate = Carbon::today()->format('Y-m-d');

        // Handle Custom Date Selection
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

        // Query for Purchases with Purchase Returns in the Selected Date Range
        $purchasesQuery = Purchase::with([
            'user:id,name',
            'party:id,name,email,phone,type',
            'details:id,purchase_id,product_id,productPurchasePrice,quantities',
            'details.product:id,productName,category_id',
            'details.product.category:id,categoryName',
            'purchaseReturns' => function ($query) {
                $query->withSum('details as total_return_amount', 'return_amount');
            }
        ])
            ->where('business_id', $businessId)
            ->whereHas('purchaseReturns', function ($query) use ($startDate, $endDate) {
                $query->whereDate('return_date', '>=', $startDate)
                    ->whereDate('return_date', '<=', $endDate);
            });

        // Search Filter
        if ($request->filled('search')) {
            $purchasesQuery->where(function ($query) use ($request) {
                $query->where('invoiceNumber', 'like', '%' . $request->search . '%')
                    ->orWhereHas('party', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // Calculate Total Purchase Return Amount in the Selected Date Range
        $total_purchase_return = PurchaseReturnDetail::whereHas('purchaseReturn', function ($query) use ($businessId, $startDate, $endDate) {
            $query->whereHas('purchase', function ($q) use ($businessId) {
                $q->where('business_id', $businessId);
            })
                ->whereDate('return_date', '>=', $startDate)
                ->whereDate('return_date', '<=', $endDate);
        })->sum('return_amount');

        // Pagination
        $perPage = $request->input('per_page', 10);
        $purchases = $purchasesQuery->latest()->paginate($perPage);

        // Handle AJAX Request
        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.purchase-return.datas', compact('purchases'))->render(),
                'total_purchase_return' => currency_format($total_purchase_return, 'icon', 2, business_currency())
            ]);
        }

        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $purchases = Purchase::with([
            'user:id,name',
            'party:id,name,email,phone,type',
            'details:id,purchase_id,product_id,productPurchasePrice,quantities',
            'details.product:id,productName,category_id',
            'details.product.category:id,categoryName',
            'purchaseReturns' => function ($query) {
                $query->withSum('details as total_return_amount', 'return_amount');
            }
        ])
            ->where('business_id', auth()->user()->business_id)
            ->whereHas('purchaseReturns')
            ->get();
        $pdf = Pdf::loadView('business::reports.purchase-return.pdf', compact('purchases'));
        return $pdf->download('purchase.report.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportPurchaseReturn, 'purchase-return.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportPurchaseReturn, 'purchase-return.csv');
    }
}
