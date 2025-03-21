<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AcnooProductController extends Controller
{
    use HasUploader;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with('unit:id,unitName', 'brand:id,brandName', 'category:id,categoryName')->where('business_id', auth()->user()->business_id)->latest()->get();

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'vat_id' => 'nullable|exists:vats,id',
            'unit_id' => 'nullable|exists:units,id',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'productCode' => [
                'nullable',
                Rule::unique('products')->where(function ($query) {
                    return $query->where('business_id', auth()->user()->business_id);
                }),
            ],
        ]);

        $data = Product::create($request->except('productPicture', 'alert_qty') + [
                    'productPicture' => $request->productPicture ? $this->upload($request, 'productPicture') : NULL,
                    'business_id' => auth()->user()->business_id,
                    'alert_qty' => $request->alert_qty ?? 0,
                ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'vat_id' => 'nullable|exists:vats,id',
            'unit_id' => 'nullable|exists:units,id',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'productCode' => [
                'nullable',
                'unique:products,productCode,' . $product->id . ',id,business_id,' . auth()->user()->business_id,
            ],
        ]);

        $product = $product->update($request->except('productPicture', 'alert_qty') + [
                'productPicture' => $request->productPicture ? $this->upload($request, 'productPicture', $product->productPicture) : $product->productPicture,
                'alert_qty' => $request->alert_qty ?? 0,
            ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (file_exists($product->productPicture)) {
            Storage::delete($product->productPicture);
        }
        $product->delete();
        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}
