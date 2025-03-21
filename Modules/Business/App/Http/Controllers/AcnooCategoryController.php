<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Category;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AcnooCategoryController extends Controller
{
    use HasUploader;

    public function index(Request $request)
    {
        $categories = Category::where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('business::categories.index', compact('categories'));
    }

    public function acnooFilter(Request $request)
    {
        $categories = Category::where('business_id', auth()->user()->business_id)
        ->when(request('search'), function($q) use($request) {
                $q->where(function($q) use($request) {
                    $q->where('categoryName', 'like', '%'.$request->search.'%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if($request->ajax()){
            return response()->json([
                'data' => view('business::categories.datas',compact('categories'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function store(Request $request)
    {
        $business_id = auth()->user()->business_id;
        $request->validate([
            'categoryName' => 'required|unique:categories,categoryName,NULL,id,business_id,' . $business_id,
            'icon' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        Category::create($request->except('variationCapacity', 'variationColor','variationSize', 'variationType', 'variationWeight', 'business_id','icon') + [
            'variationCapacity' => $request->variationCapacity == 'true' ? 1 : 0,
            'variationColor' => $request->variationColor == 'true' ? 1 : 0,
            'variationSize' => $request->variationSize == 'true' ? 1 : 0,
            'variationType' => $request->variationType == 'true' ? 1 : 0,
            'variationWeight' => $request->variationWeight == 'true' ? 1 : 0,
            'business_id' => auth()->user()->business_id,
            'icon' => $request->icon ? $this->upload($request, 'icon') : NULL,
        ]);


        return response()->json([
            'message' => __('Category created successfully'),
            'redirect' => route('business.categories.index'),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'categoryName' => [
                'required',
                'unique:categories,categoryName,' . $category->id . ',id,business_id,' . auth()->user()->business_id,
            ],
            'icon' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $category->update([
            'categoryName' => $request->categoryName,
            'variationCapacity' => $request->variationCapacity == 'true' ? 1 : 0,
            'variationColor' => $request->variationColor == 'true' ? 1 : 0,
            'variationSize' => $request->variationSize == 'true' ? 1 : 0,
            'variationType' => $request->variationType == 'true' ? 1 : 0,
            'variationWeight' => $request->variationWeight == 'true' ? 1 : 0,
            'icon' => $request->icon ? $this->upload($request, 'icon',$category->icon) : $category->icon,
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message' => __('Category updated successfully'),
            'redirect' => route('business.categories.index'),
        ]);
    }

    public function destroy(Category $category)
    {
        if (file_exists($category->icon)) {
            Storage::delete($category->icon);
        }

        $category->delete();

        return response()->json([
            'message' => __('Category deleted successfully'),
            'redirect' => route('business.categories.index'),
        ]);
    }

    public function status(Request $request, $id)
    {
        $categoryStatus = Category::findOrFail($id);
        $categoryStatus->update(['status' => $request->status]);
        return response()->json(['message' => __('Category')]);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        DB::beginTransaction();
        try {
            $categories = Category::whereIn('id', $idsToDelete)->get();
            foreach ($categories as $category) {
                if (file_exists($category->icon)) {
                    Storage::delete($category->icon);
                }
            }

            Category::whereIn('id', $idsToDelete)->delete();

            DB::commit();

            return response()->json([
                'message' => __('Selected Category deleted successfully'),
                'redirect' => route('admin.categories.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }

    }
}
