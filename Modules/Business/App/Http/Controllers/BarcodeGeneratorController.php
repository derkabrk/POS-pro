<?php

namespace Modules\Business\App\Http\Controllers;

use AgeekDev\Barcode\Facades\Barcode;
use AgeekDev\Barcode\Enums\Type;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BarcodeGeneratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barcode_types = array_map(
            fn($case) => ['value' => $case->value],
            Type::cases()
        );

        $products = Product::where('business_id', auth()->user()->business_id)->latest()->get();
        return view('business::barcode-generators.index', compact('products', 'barcode_types'));
    }

    public function fetchProducts(Request $request)
    {
        $products = Product::where('business_id', auth()->user()->business_id)
            ->when(!empty($request->search), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('productName', 'like', '%' . $request->search . '%')
                        ->orWhere('productCode', 'like', '%' . $request->search . '%');
                });
            }, function ($q) {
                $q->limit(5); // Limit 5 when search is empty
            })
            ->get();

        return response()->json($products);
    }



    public function store(Request $request)
    {
        $barcodeType = $request->input('barcode_type', Type::TYPE_CODE_128->value);
        $productIds = $request->input('product_ids', []);
        $quantities = $request->input('qty', []);
        $previewDates = $request->input('preview_date', []);

        if (empty($productIds)) {
            return response()->json(['message' => __('Please select at least one product.')], 400);
        }

        $generatedBarcodes = [];

        foreach ($productIds as $index => $productId) {
            $product = Product::find($productId);

            if (!$product) {
                continue; // Skip if product not found
            }

            $qty = $quantities[$index] ?? 1;
            $previewDate = $previewDates[$index] ?? null;

            for ($i = 0; $i < $qty; $i++) {
                $barcodeSvg = Barcode::imageType("png")
                    ->type(Type::from($barcodeType)) // Use the barcode type enum
                    ->generate($product->productCode);

                $generatedBarcodes[] = [
                    'product_name' => $product->productName,
                    'product_code' => $product->productCode,
                    'product_price' => $product->productSalePrice,
                    'product_stock' => $product->productStock,
                    'packing_date' => $previewDate,
                    'barcode_svg' => $barcodeSvg,
                    'show_product_name' => $request->product_name,
                    'product_name_size' => $request->product_name_size,
                    'show_product_price' => $request->product_price,
                    'product_price_size' => $request->product_price_size,
                    'show_product_code' => $request->product_code,
                    'product_code_size' => $request->product_code_size,
                    'show_pack_date' => $request->pack_date,
                    'pack_date_size' => $request->pack_date_size,
                ];
            }
        }

        session(['generatedBarcodes' => $generatedBarcodes]);

        return response()->json([
            'redirect'  => route('business.barcodes.index'),
            'secondary_redirect_url'  => route('business.barcodes.preview'),
        ]);
    }

    public function preview()
    {
        $generatedBarcodes = session('generatedBarcodes');
        session()->forget('generatedBarcodes');

        return view('business::barcode-generators.print', compact('generatedBarcodes'));
    }

}
