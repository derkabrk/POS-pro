<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use Illuminate\Http\Request;

class AcnooBusinessCategoryController extends Controller
{
    public function index()
    {
        $categories = BusinessCategory::latest()->paginate(20);
        return view('admin.business-categories.index', compact('categories'));
    }

    public function acnooFilter(Request $request)
    {
        $categories = BusinessCategory::when(request('search'), function ($q) {
            $q->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        })
            ->latest()
            ->paginate($request->per_page ?? 20);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.business-categories.datas', compact('categories'))->render()
            ]);
        }

        return redirect(url()->previous());
    }


    public function create()
    {
        return view('admin.business-categories.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'status' => 'nullable|in:on',
            'description' => 'nullable|string|max:255',
            'name' => 'required|string|unique:business_categories|max:255',
        ]);

        BusinessCategory::create($request->except('status') + [
            'status' => $request->status ? 1 : 0,
        ]);

        return response()->json([
            'message'   => __('Category saved successfully'),
            'redirect'  => route('admin.business-categories.index')
        ]);
    }

    public function edit($id)
    {
        $category = BusinessCategory::find($id);
        return view('admin.business-categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'in:on',
            'description' => 'nullable|string|max:255',
            'name' => 'required|string|max:255|unique:business_categories,name,' . $id,
        ]);

        $category = BusinessCategory::find($id);

        $category->update($request->except('status') + [
            'status' => $request->status ? 1 : 0,
        ]);

        return response()->json([
            'message'   => __('Category updated successfully'),
            'redirect'  => route('admin.business-categories.index')
        ]);
    }

    public function destroy($id)
    {
        $category = BusinessCategory::findOrFail($id);
        $category->delete();
        return response()->json([
            'message'   => __('Category deleted successfully'),
            'redirect'  => route('admin.business-categories.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        BusinessCategory::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message'   => __('Category deleted successfully'),
            'redirect'  => route('admin.business-categories.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $category = BusinessCategory::findOrFail($id);
        $category->update(['status' => $request->status]);
        return response()->json(['message' => 'Business category']);
    }
}
