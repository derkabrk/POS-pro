<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCompanies;
use Illuminate\Http\Request;

class AcnooShippingCompaniesController extends Controller
{
    public function index()
    {
        $categories = ShippingCompanies::latest()->paginate(20);
        return view('admin.shipping-companies.index', compact('categories'));
    }

    public function acnooFilter(Request $request)
    {
        $categories = ShippingCompanies::when(request('search'), function ($q) {
            $q->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        })
            ->latest()
            ->paginate($request->per_page ?? 20);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.shipping-companies.datas', compact('categories'))->render()
            ]);
        }

        return redirect(url()->previous());
    }


    public function create()
    {
        return view('admin.shipping-companies.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'address' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        ShippingCompanies::create($request);

        return response()->json([
            'message'   => __('Shipping Company saved successfully'),
            'redirect'  => route('admin.business-categories.index')
        ]);
    }

    public function edit($id)
    {
        $category = ShippingCompanies::find($id);
        return view('admin.shipping-companies.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'in:on',
            'description' => 'nullable|string|max:255',
            'name' => 'required|string|max:255,name,' . $id,
        ]);

        $category = ShippingCompanies::find($id);

        $category->update($request->except('status') + [
            'status' => $request->status ? 1 : 0,
        ]);

        return response()->json([
            'message'   => __('Category updated successfully'),
            'redirect'  => route('admin.shipping-companies.index')
        ]);
    }

    public function destroy($id)
    {
        $category = ShippingCompanies::findOrFail($id);
        $category->delete();
        return response()->json([
            'message'   => __('Category deleted successfully'),
            'redirect'  => route('admin.shipping-companies.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        ShippingCompanies::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message'   => __('Category deleted successfully'),
            'redirect'  => route('admin.shipping-companies.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $category = ShippingCompanies::findOrFail($id);
        $category->update(['status' => $request->status]);
        return response()->json(['message' => 'Business category']);
    }
}
