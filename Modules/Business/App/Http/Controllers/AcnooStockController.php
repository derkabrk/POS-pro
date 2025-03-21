<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportCurrentStock;

class AcnooStockController extends Controller
{

    public function index()
    {
        $businessId = auth()->user()->business_id;
        $alert_qty_filter = request('alert_qty');

        $query = Product::where('business_id', $businessId);

        if ($alert_qty_filter) {
            $query->whereColumn('productStock', '<=', 'alert_qty');
        }

        $total_stock_value = (clone $query)->selectRaw('SUM(productSalePrice * productStock) as total_value')->value('total_value');
        $total_qty = (clone $query)->sum('productStock');
        $stocks = $query->latest()->paginate(20);

        return view('business::stocks.index', compact('stocks','total_stock_value','total_qty'));
    }

    public function acnooFilter(Request $request)
    {
        $businessId = auth()->user()->business_id;

        $query = Product::where('business_id', $businessId);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('productName', 'like', '%' . $request->search . '%')
                    ->orWhere('productSalePrice', 'like', '%' . $request->search . '%')
                    ->orWhere('productStock', 'like', '%' . $request->search . '%')
                    ->orWhere('productPurchasePrice', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->alert_qty) {
            $query->whereColumn('productStock', '<=', 'alert_qty');
        }

        $total_stock_value = (clone $query)->selectRaw('SUM(productSalePrice * productStock) as total_value')->value('total_value');
        $total_qty = (clone $query)->sum('productStock');

        $stocks = $query->latest()->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::stocks.datas', compact('stocks', 'total_stock_value', 'total_qty'))->render()
            ]);
        }

        return redirect(url()->previous());
    }


    public function generatePDF(Request $request)
    {
        $stocks = Product::where('business_id', auth()->user()->business_id)->latest()->get();
        $pdf = Pdf::loadView('business::stocks.pdf', compact('stocks'));
        return $pdf->download('current-stock.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportCurrentStock, 'current-stock.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportCurrentStock, 'current-stock.csv');
    }
}
