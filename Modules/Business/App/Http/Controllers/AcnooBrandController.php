<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Helpers\HasUploader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AcnooBrandController extends Controller
{
    use HasUploader;

    public function index()
    {
        $brands = Brand::where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('business::brands.index', compact('brands'));
    }

    public function acnooFilter(Request $request)
    {
        $brands = Brand::where('business_id', auth()->user()->business_id)
        ->when(request('search'), function($q) use($request) {
                $q->where(function($q) use($request) {
                    $q->where('brandName', 'like', '%'.$request->search.'%')
                      ->orWhere('description', 'like', '%'.$request->search.'%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if($request->ajax()){
            return response()->json([
                'data' => view('business::brands.datas',compact('brands'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function store(Request $request)
    {
        $request->validate([
            'brandName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        Brand::create($request->except('business_id','icon') + [
            'business_id' => auth()->user()->business_id,
            'icon' => $request->icon ? $this->upload($request, 'icon') : NULL,
        ]);

        return response()->json([
            'message' => __('Brand created cuccessfully'),
            'redirect' => route('business.brands.index'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $request->validate([
            'brandName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);


        $brand->update([
            'brandName' => $request->brandName,
            'icon' => $request->icon ? $this->upload($request, 'icon', $brand->icon) : $brand->icon
        ]);

        return response()->json([
            'message' => __('Brand updated successfully'),
            'redirect' => route('business.brands.index'),
        ]);
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if (file_exists($brand->icon)) {
            Storage::delete($brand->icon);
        }

        $brand->delete();

        return response()->json([
            'message' => __('Brand deleted successfully'),
            'redirect' => route('business.brands.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->update(['status' => $request->status]);
        return response()->json(['message' => __('Brand')]);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            $brands = Brand::whereIn('id', $idsToDelete)->get();
            foreach ($brands as $brand) {
                if (file_exists($brand->icon)) {
                    Storage::delete($brand->icon);
                }
            }

            Brand::whereIn('id', $idsToDelete)->delete();

            DB::commit();

            return response()->json([
                'message' => __('Selected Brands deleted successfully'),
                'redirect' => route('business.brands.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }
    }
}
