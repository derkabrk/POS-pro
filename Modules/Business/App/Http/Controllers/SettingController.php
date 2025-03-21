<?php

namespace Modules\Business\App\Http\Controllers;

use App\Helpers\HasUploader;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    use HasUploader;

    public function index()
    {
        $setting = Option::where('key', 'business-settings')
                            ->whereJsonContains('value->business_id', auth()->user()->business_id)
                            ->first();

        $business_categories = BusinessCategory::whereStatus(1)->latest()->get();
        $business = Business::findOrFail(auth()->user()->business_id);

        return view('business::settings.general',compact('setting','business_categories', 'business'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => 'nullable|max:250',
            'companyName' => 'required|max:250',
            'business_category_id' => 'required|exists:business_categories,id',
            'phoneNumber' => 'nullable', 'min:5', 'max:15',
            'vat_name' => 'nullable|max:250',
            'vat_no' => 'nullable|max:250|required_with:vat_name',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
            'invoice_logo' => 'nullable|image',
        ]);

        DB::beginTransaction();

        try {
            $business = Business::findOrFail(auth()->user()->business_id);

            $business->update([
                'address' => $request->address,
                'companyName' => $request->companyName,
                'business_category_id' => $request->business_category_id,
                'phoneNumber' => $request->phoneNumber,
                'vat_name' => $request->vat_name,
                'vat_no' => $request->vat_no,
            ]);

            $data = $request->except('_token', '_method', 'logo', 'favicon', 'invoice_logo', 'address', 'companyName', 'business_category_id', 'phoneNumber');

            $setting = Option::find($id);

            if ($setting) {
                $setting->update($request->except($data) + [
                        'value' => $request->except('_token', '_method', 'logo', 'favicon', 'invoice_logo', 'address', 'companyName', 'business_category_id', 'phoneNumber') + [
                                'business_id' => $business->id,
                                'logo' => $request->logo ? $this->upload($request, 'logo', $setting->value['logo'] ?? null) : ($setting->value['logo'] ?? null),
                                'favicon' => $request->favicon ? $this->upload($request, 'favicon', $setting->value['favicon'] ?? null) : ($setting->value['favicon'] ?? null),
                                'invoice_logo' => $request->invoice_logo ? $this->upload($request, 'invoice_logo', $setting->value['invoice_logo'] ?? null) : ($setting->value['invoice_logo'] ?? null),
                            ],
                    ]);
            } else {
                Option::insert([
                    'key' => 'business-settings',
                    'value' => json_encode([
                        'business_id' => $business->id,
                        'logo' => $request->logo ? $this->upload($request, 'logo') : null,
                        'favicon' => $request->favicon ? $this->upload($request, 'favicon') : null,
                        'invoice_logo' => $request->invoice_logo ? $this->upload($request, 'invoice_logo') : null,
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Cache::forget('business-settings');

            DB::commit();

            return response()->json([
                'message' => __('Business General Setting updated successfully'),
                'redirect' => route('business.settings.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(__('Something was wrong.'), 400);
        }
    }
}
