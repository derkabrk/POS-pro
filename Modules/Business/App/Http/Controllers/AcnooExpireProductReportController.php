<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportExpiredProductReport;

class AcnooExpireProductReportController extends Controller
{

    public function index()
    {
        $expired_products = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')
                        ->where('business_id', auth()->user()->business_id)
                        ->whereDate('expire_date', Carbon::today()->format('Y-m-d'))
                        ->latest()
                        ->paginate(20);

        return view('business::reports.expired-products.index', compact('expired_products'));
    }


    public function acnooFilter(Request $request)
    {
        $businessId = auth()->user()->business_id;
        $expiredProductsQuery = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')
            ->where('business_id', $businessId);

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

        $expiredProductsQuery->whereBetween('expire_date', [$startDate, $endDate]);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $expiredProductsQuery->where(function ($query) use ($search) {
                $query->where('productName', 'like', '%' . $search . '%')
                    ->orWhere('productCode', 'like', '%' . $search . '%')
                    ->orWhere('productPurchasePrice', 'like', '%' . $search . '%')
                    ->orWhere('productSalePrice', 'like', '%' . $search . '%')
                    ->orWhere('productStock', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('categoryName', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('brandName', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('unit', function ($q) use ($search) {
                        $q->where('unitName', 'like', '%' . $search . '%');
                    });
            });
        }

        $perPage = $request->input('per_page', 10);
        $expired_products = $expiredProductsQuery->latest()->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.expired-products.datas', compact('expired_products'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function exportExcel()
    {
        return Excel::download(new ExportExpiredProductReport, 'expired-product-reports.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportExpiredProductReport, 'expired-product-reports.csv');
    }
}
