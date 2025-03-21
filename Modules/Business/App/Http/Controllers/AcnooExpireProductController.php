<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportExpiredProduct;

class AcnooExpireProductController extends Controller
{

    public function index()
    {
        $expired_products = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')->where('business_id', auth()->user()->business_id)->where('expire_date', '<', date('Y-m-d'))->latest()->paginate(20);
        return view('business::expired-products.index', compact('expired_products'));
    }


    public function acnooFilter(Request $request)
    {
        $search = $request->input('search');

        $expired_products = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')->where('business_id', auth()->user()->business_id)->where('expire_date', '<', date('Y-m-d'))->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('productName', 'like', '%' . $search . '%')
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
        })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::expired-products.datas', compact('expired_products'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function exportExcel()
    {
        return Excel::download(new ExportExpiredProduct, 'expired-products.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportExpiredProduct, 'expired-products.csv');
    }
}
