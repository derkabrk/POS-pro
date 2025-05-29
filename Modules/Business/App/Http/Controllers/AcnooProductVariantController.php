<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AcnooProductVariantController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('business::products.variants', compact('variants'));
    }

    public function create()
    {
        return view('business::products.variant-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'variantName' => 'required|string|max:255',
            'variantCode' => 'required|string|max:255|unique:product_variants,variantCode',
            'status' => 'required|boolean',
        ]);

        // Create the main ProductVariant
        $variant = ProductVariant::create($request->except('business_id', 'sub_variants', 'sub_variant_skus') + [
            'business_id' => auth()->user()->business_id,
        ]);

        // Save sub-variants if provided (UI sends arrays)
        $subVariants = $request->input('sub_variants', []);
        $subVariantSkus = $request->input('sub_variant_skus', []);
        $count = max(count($subVariants), count($subVariantSkus));
        for ($i = 0; $i < $count; $i++) {
            $name = $subVariants[$i] ?? null;
            $sku = $subVariantSkus[$i] ?? null;
            if ($name || $sku) {
                \App\Models\SubVariant::create([
                    'product_variant_id' => $variant->id,
                    'business_id' => $variant->business_id,
                    'name' => $name,
                    'sku' => $sku,
                    'status' => 1,
                ]);
            }
        }

        return redirect()->route('business.product-variants.index')->with('success', __('Product Variant created successfully'));
    }

    public function edit($id)
    {
        $variant = ProductVariant::findOrFail($id);
        return view('business::products.variant-create', compact('variant'));
    }

    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $request->validate([
            'variantName' => 'required|string|max:255',
            'variantCode' => 'required|string|max:255|unique:product_variants,variantCode,' . $id,
            'status' => 'required|boolean',
        ]);
        $variant->update($request->all());
        return response()->json([
            'message' => __('Product Variant updated successfully'),
            'redirect' => route('business.product-variants.index'),
        ]);
    }

    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();
        return response()->json([
            'message' => __('Product Variant deleted successfully'),
            'redirect' => route('business.product-variants.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->update(['status' => $request->status]);
        return response()->json(['message' => __('Product Variant status updated')]);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            ProductVariant::whereIn('id', $idsToDelete)->delete();
            DB::commit();
            return response()->json([
                'message' => __('Selected Product Variants deleted successfully'),
                'redirect' => route('business.product-variants.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }
    }

    public function acnooFilter(Request $request)
    {
        $variants = ProductVariant::where('business_id', auth()->user()->business_id)
            ->when($request->search, function($q) use($request) {
                $q->where(function($q) use($request) {
                    $q->where('variantName', 'like', '%'.$request->search.'%')
                      ->orWhere('variantCode', 'like', '%'.$request->search.'%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if($request->ajax()){
            return response()->json([
                'data' => view('business::products.partials.variant-datas',compact('variants'))->render()
            ]);
        }
        return redirect(url()->previous());
    }
}
