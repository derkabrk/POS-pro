<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Shipping;
use App\Models\ShippingCompanies;
use App\Models\User;
use App\Models\Business;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportCurrentStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AcnooShippingController extends Controller
{

    public function index()
    {
        $shippings = Shipping::where('business_id', auth()->user()->business_id)->paginate(20);
        return view('business::shipping.index', compact('shippings'));
    }

    public function create()

    
    {
        $json = File::get(storage_path('app/Wilaya_Of_Algeria.json'));
        $wilayas = json_decode($json, true);
        $shipping_companys = ShippingCompanies::latest()->get();
        return view('business::shipping.create' ,compact('shipping_companys','wilayas'));
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

        $stepdeskSelections = $request->input('stepdesk', []);
        $deliverySelections = $request->input('delivery_home', []);

        // Store as JSON array in a single record
        $shipping_wilayas = [
            'stepdesk' => $stepdeskSelections,
            'delivery_home' => $deliverySelections
        ];

     DB::beginTransaction();

        try {

            if ($request->shipping_company_id) {
                $shipping_company = ShippingCompanies::findOrFail($request->shipping_company_id);
            }

            $shipping = Shipping::create([
                'first_r_credential' => $request->first_r_credential,
                'second_r_credential' => $request->second_r_credential,
                'name' =>  $request->name,
                'business_id' =>  auth()->user()->business_id,
                'shipping_company' => $shipping_company->name,
                'shipping_company_id' => $shipping_company->id,
                'is_active' =>  $request->status ? 1 : 0,
                'shops'  => json_encode([]),
                'shipping_wilayas' => json_encode($shipping_wilayas)
            ]);

            DB::commit();

            return response()->json([
                'message' => __('Shipping service saved successfully.'),
                'redirect' => route('business.shipping.index'),
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            \Log::error("Error in transaction: " . $th->getMessage());
            return response()->json([
                'error' => __('Something went wrong.'),
                'message' => $th->getMessage(),
            ], 403);
        }
    }


    public function update(Request $request,$id)
    {

        $shipping_companys = ShippingCompanies::latest()->get();


        $request->validate([
            'first_r_credential' => 'nullable|max:250',
            'second_r_credential' => 'required|max:250',
            'name' => 'required|max:250',
            'shipping_company_id' => 'required|exists:shipping_companies,id',
        ]);

        $stepdeskSelections = $request->input('stepdesk', []);
        $deliverySelections = $request->input('delivery_home', []);
    
        // Store updated selections as JSON array
        $selections = [
            'stepdesk' => $stepdeskSelections,
            'delivery_home' => $deliverySelections
        ];
    

     DB::beginTransaction();

        try {

            if ($request->shipping_company_id) {
                $shipping_company = ShippingCompanies::findOrFail($request->shipping_company_id);
            }

            $shipping = Shipping::find($id); // Find the record by ID
            $shipping->update([
                'first_r_credential' => $request->first_r_credential,
                'second_r_credential' => $request->second_r_credential,
                'name' => $request->name,
                'shipping_company' => $shipping_company->name,
                'shipping_company_id' => $shipping_company->id,
                'is_active' => $request->status ? 1 : 0,
                'shops' => json_encode([]),
                'shipping_wilayas' => json_encode($selections),
            ]);

            DB::commit();

            return response()->json([
                'message' => __('Shipping service updated successfully.'),
                'redirect' => route('business.shipping.index'),
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            \Log::error("Error in transaction: " . $th->getMessage());
            return response()->json([
                'error' => __('Something went wrong.'),
                'message' => $th->getMessage(),
            ], 403);
        }
    }

    
    public function edit($id)
    {
        $shipping = Shipping::find($id);
        $shipping_company = ShippingCompanies::findOrFail($shipping->shipping_company_id);
        $shipping_companys  = ShippingCompanies::latest()->get();
        $selections = $shipping ? json_decode($shipping->shipping_wilayas, true) : [];
        $selectedStepdesk  = $selections['stepdesk'];
        $selectedDelivery  = $selections['delivery_home'];
        $json = File::get(storage_path('app/Wilaya_Of_Algeria.json'));
        $wilayas = json_decode($json, true);
        return view('business::shipping.edit', compact("shipping","shipping_company","shipping_companys", 
        "wilayas","selectedStepdesk","selectedDelivery"));
    }

    public function destroy($id)
    {
        if (Shipping::findOrFail($id)) {
            $shipping = Shipping::find($id);
            $shipping->delete();
            return response()->json([
                'message' => __('Shipping service deleted successfully'),
                'redirect' => route('business.shipping.index'),
            ]);
        }else{
            return response()->json([
                'error' => __('Something went wrong.'),
                'message' => "Invalid Id",
            ], 404);
        }
    }

}