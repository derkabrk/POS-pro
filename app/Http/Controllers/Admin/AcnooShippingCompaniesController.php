<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCompanies;
use Illuminate\Http\Request;

class AcnooShippingCompaniesController extends Controller
{
    public function index()
    {
        $shippingCompanies = ShippingCompanies::latest()->paginate(20);
        return view('admin.shipping-companies.index', compact('shippingCompanies'));
    }

    public function acnooFilter(Request $request)
    {
        $shippingCompanies = ShippingCompanies::when(request('search'), function ($q) {
            $q->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        })
            ->latest()
            ->paginate($request->per_page ?? 20);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.shipping-companies.datas', compact('shippingCompanies'))->render()
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
        // **Validation**
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'required|email|unique:shipping_companies,email',
            'address' => 'nullable|string|max:255',

            'create_api_url'  => 'required|string|max:255',
            'update_api_url'  => 'required|string|max:255',
            'delete_api_url'  => 'required|string|max:255',
            'update_api_url'  => 'required|string|max:255',
            'list_api_url'    => 'required|string|max:255',
            'track_api_url'   => 'required|string|max:255',
            'first_r_credential_lable'   => 'required|string|max:255',
            'second_r_credential_lable'   => 'required|string|max:255',
        ]);

        // **Store data**
        ShippingCompanies::create($validatedData);

       return response()->json([
       'message'   => __('Shipping Company saved successfully'),
       'redirect'  => route('admin.shipping-companies.index')
        ]);
    }


    public function edit($id)
    {
        $shippingCompany = ShippingCompanies::find($id);
        return view('admin.shipping-companies.edit', compact('shippingCompany'));
    }

    public function update(Request $request, $id)
    {
        $shippingCompany = ShippingCompanies::findOrFail($id);

        // **Validation**
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'email' => 'required|email|unique:shipping_companies,email,'.$id,
            'address' => 'nullable|string|max:255',
            'create_api_url'  => 'required|string|max:255',
            'update_api_url'  => 'required|string|max:255',
            'delete_api_url'  => 'required|string|max:255',
            'update_api_url'  => 'required|string|max:255',
            'list_api_url'    => 'required|string|max:255',
            'track_api_url'   => 'required|string|max:255',
            'first_r_credential_lable'   => 'required|string|max:255',
            'second_r_credential_lable'   => 'required|string|max:255',
        ]);
    
        // **Update record**
        $shippingCompany->update($validatedData);

        return response()->json([
            'message'   => __('Shipping Company info updated successfully'),
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
