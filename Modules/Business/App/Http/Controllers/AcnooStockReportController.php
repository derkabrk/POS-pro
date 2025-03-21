<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportStock;

class AcnooStockReportController extends Controller
{
    public function index()
    {
        $total_stock_value = Product::where('business_id', auth()->user()->business_id)->selectRaw('SUM(productPurchasePrice * productStock) as total_value')->value('total_value');
        $total_qty = Product::where('business_id', auth()->user()->business_id)->sum('productStock');
        $stocks = Product::where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('business::reports.stocks.stock-reports', compact('stocks','total_stock_value','total_qty'));
    }

    public function acnooFilter(Request $request)
    {
        $stocks = Product::where('business_id', auth()->user()->business_id)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('productName', 'like', '%' . $request->search . '%')
                    ->orwhere('productStock', 'like', '%' . $request->search . '%')
                    ->orwhere('productSalePrice', 'like', '%' . $request->search . '%')
                    ->orwhere('productPurchasePrice', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.stocks.datas', compact('stocks'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $stocks = Product::where('business_id', auth()->user()->business_id)->latest()->get();
        $pdf = Pdf::loadView('business::reports.stocks.pdf', compact('stocks'));
        return $pdf->download('reports.stocks.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportStock, 'stock.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportStock, 'stock.csv');
    }

}
