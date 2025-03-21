<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Shipping;
use App\Models\ShippingCompanies;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportCurrentStock;

class AcnooShippingController extends Controller
{

    public function index()
    {
        $shippings = Shipping::latest()->paginate(20);
        return view('business::shipping.index', compact('shippings'));
    }


    public function store(Request $request)
    {

        $shipping_companys = ShippingCompanies::latest()->get();

        
        $request->validate([
            'first_r_credential' => 'nullable|max:250',
            'second_r_credential' => 'required|max:250',
            'name' => 'required|max:250',
            'shipping_company_id' => 'required|exists:shipping_companies,id',
        ]);

        DB::beginTransaction();

        try {


            $user = auth()->user();

            if ($request->shipping_company_id) {
                $shipping_company = ShippingCompanies::findOrFail($request->shipping_company_id);
            }

            $business = Shipping::create([
                'first_r_credential' => $request->first_r_credential,
                'second_r_credential' => $request->second_r_credential,
                'name' =>  $request->name,
                'shipping_company' => $shipping_company->name,
                'shipping_company_id' => $request->shipping_company_id,
            ]);

            DB::commit();

            return response()->json([
                'message' => __('Shipping service saved successfully.'),
                'redirect' => route('business::shipping.dates'),
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(__('Something went wrong.'), 403);
        }
    }

}