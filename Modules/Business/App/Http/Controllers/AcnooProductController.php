<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\HasUploader;
use App\Models\Vat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Modules\Business\App\Exports\ExportProduct;

class AcnooProductController extends Controller
{
    use HasUploader;

    public function index()
    {
        $products = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')->where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('business::products.index', compact('products'));
    }

    public function acnooFilter(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')->where('business_id', auth()->user()->business_id)->when($search, function ($q) use ($search) {
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
                'data' => view('business::products.datas', compact('products'))->render()
            ]);
        }

        return redirect(url()->previous());
    }


    public function create()
    {
        $categories = Category::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $brands = Brand::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $units = Unit::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $product_id = (Product::max('id') ?? 0) + 1;
        $vats = Vat::where('business_id', auth()->user()->business_id)->latest()->get();
        $code = str_pad($product_id , 4, '0', STR_PAD_LEFT);

        return view('business::products.create', compact('categories', 'brands', 'units', 'code','vats'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'vat_id' => 'nullable|exists:vats,id',
            'vat_type' => 'nullable|in:inclusive,exclusive',
            'productName' => 'required|string|max:255',
            'unit_id' => 'nullable|exists:units,id',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'productPicture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'productDealerPrice' => 'nullable|numeric|min:0',
            'exclusive_price' => 'required|numeric|min:0',
            'inclusive_price' => 'required|numeric|min:0',
            'profit_percent' => 'nullable|numeric',
            'productSalePrice' => 'required|numeric|min:0',
            'productWholeSalePrice' => 'nullable|numeric|min:0',
            'productStock' => 'nullable|numeric|min:0',
            'alert_qty' => 'nullable|numeric|min:0',
            'expire_date' => 'nullable|date',
            'size' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'productManufacturer' => 'nullable|string|max:255',
            'productCode' => [
                'nullable',
                Rule::unique('products')->where(function ($query) {
                    return $query->where('business_id', auth()->user()->business_id);
                }),
            ],
        ]);

        //vat calculation
        $vat = Vat::find($request->vat_id);
        $exclusive_price = $request->exclusive_price ?? 0;
        $vat_amount = ($exclusive_price * ($vat->rate ?? 0)) / 100;

        if( $request->vat_type == 'exclusive'){
            $purchase_price = $request->exclusive_price;
        }else{
            $purchase_price = $request->exclusive_price + $vat_amount;
        }

        Product::create($request->except(['productPicture', 'productDealerPrice', 'productWholeSalePrice', 'productStock', 'alert_qty', 'vat_amount']) + [
            'productPicture' => $request->productPicture ? $this->upload($request, 'productPicture') : NULL,
            'productPurchasePrice' => $purchase_price,
            'productSalePrice' => $request->productSalePrice,
            'productDealerPrice' => $request->productDealerPrice ?? $request->productSalePrice,
            'productWholeSalePrice' => $request->productWholeSalePrice ?? $request->productSalePrice,
            'productStock' => $request->productStock ?? 0,
            'alert_qty' => $request->alert_qty ?? 0,
            'vat_amount' => $vat_amount,
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message' => __('Product saved successfully.'),
            'redirect' => route('business.products.index')
        ]);
    }

    public function edit($id)
    {
        $product = Product::where('business_id', auth()->user()->business_id)->findOrFail($id);
        $categories = Category::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $brands = Brand::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $units = Unit::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $vats = Vat::where('business_id', auth()->user()->business_id)->latest()->get();

        return view('business::products.edit', compact('categories', 'brands', 'units', 'product', 'vats'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'vat_id' => 'nullable|exists:vats,id',
            'vat_type' => 'nullable|in:inclusive,exclusive',
            'productName' => 'required|string|max:255',
            'unit_id' => 'nullable|exists:units,id',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'productPicture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'productDealerPrice' => 'nullable|numeric|min:0',
            'exclusive_price' => 'required|numeric|min:0',
            'inclusive_price' => 'required|numeric|min:0',
            'profit_percent' => 'nullable|numeric',
            'productSalePrice' => 'required|numeric|min:0',
            'productWholeSalePrice' => 'nullable|numeric|min:0',
            'productStock' => 'nullable|numeric|min:0',
            'alert_qty' => 'nullable|numeric|min:0',
            'expire_date' => 'nullable|date',
            'size' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'productManufacturer' => 'nullable|string|max:255',
            'productCode' => [
                'nullable',
                'unique:products,productCode,' . $product->id . ',id,business_id,' . auth()->user()->business_id,
            ],
        ]);


        //vat calculation
        $vat = Vat::find($request->vat_id);
        $exclusive_price = $request->exclusive_price ?? 0;
        $vat_amount = ($exclusive_price * ($vat->rate ?? 0)) / 100;

        if( $request->vat_type == 'exclusive'){
            $purchase_price = $request->exclusive_price;
        }else{
            $purchase_price = $request->exclusive_price + $vat_amount;
        }

        $product->update($request->except(['productPicture', 'productDealerPrice', 'productWholeSalePrice', 'productStock', 'alert_qty']) + [
            'productPicture' => $request->productPicture ? $this->upload($request, 'productPicture', $product->productPicture) : $product->productPicture,
            'productPurchasePrice' => $purchase_price,
            'productSalePrice' => $request->productSalePrice,
            'productDealerPrice' => $request->productDealerPrice ?? $request->productSalePrice,
            'productWholeSalePrice' => $request->productWholeSalePrice ?? $request->productSalePrice,
            'productStock' => $request->productStock ?? 0,
            'alert_qty' => $request->alert_qty ?? 0,
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'redirect' => route('business.products.index')
        ]);
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if(file_exists($product->productPicture)) {
            Storage::delete($product->productPicture);
        }
        $product->delete();

        return response()->json([
            'message' => __('Product deleted successfully'),
            'redirect' => route('business.products.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
       $products = Product::whereIn('id', $request->ids)->get();

        foreach($products as $product) {
            if(file_exists($product->productPicture)) {
                Storage::delete($product->productPicture);
            }
        }
        Product::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message'   => __('Selected product deleted successfully'),
            'redirect'  => route('business.products.index')
        ]);
    }

    public function generatePDF(Request $request)
    {
        $products = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')->where('business_id', auth()->user()->business_id)->latest()->get();
        $pdf = Pdf::loadView('business::products.pdf', compact('products'));
        return $pdf->download('product.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportProduct, 'product.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportProduct, 'product.csv');
    }
}
