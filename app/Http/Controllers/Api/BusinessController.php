<?php

namespace App\Http\Controllers\Api;

use App\Models\Plan;
use App\Models\User;
use App\Models\Business;
use App\Models\Currency;
use App\Helpers\HasUploader;
use App\Models\UserCurrency;
use Illuminate\Http\Request;
use App\Models\PlanSubscribe;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BusinessController extends Controller
{
    use HasUploader;

    public function index()
    {
        $business_id = auth()->user()->business_id;
        $business_currency = UserCurrency::select('id', 'name', 'code', 'symbol', 'position')->where('business_id', $business_id)->first();

        if (!$business_currency) {
            $currency = Currency::where('is_default', 1)->first();
            UserCurrency::create([
                'name' => $currency->name,
                'code' => $currency->code,
                'rate' => $currency->rate,
                'business_id' => $business_id,
                'symbol' => $currency->symbol,
                'currency_id' => $currency->id,
                'position' => $currency->position,
                'country_name' => $currency->country_name,
            ]);
        }

        $user = User::select('id', 'name', 'role', 'visibility', 'lang', 'email')->findOrFail(auth()->id());
        $business = Business::with('category:id,name', 'enrolled_plan:id,plan_id,business_id,price,duration', 'enrolled_plan.plan:id,subscriptionName')->findOrFail($business_id);

        $data = array_merge($business->toArray(), ['user' => $user->toArray()], ['business_currency' => $business_currency]);

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'nullable|max:250',
            'companyName' => 'required|max:250',
            'pictureUrl' => 'nullable|image|max:5120',
            'shopOpeningBalance' => 'nullable|numeric',
            'business_category_id' => 'required|exists:business_categories,id',
        ]);

        DB::beginTransaction();
        try {

            $user = auth()->user();
            $free_plan = Plan::where('subscriptionPrice', '<=', 0)->orWhere('offerPrice', '<=', 0)->first();

            $business = Business::create($request->except('pictureUrl') + [
                            'phoneNumber' => $request->phoneNumber,
                            'subscriptionDate' => $free_plan ? now() : NULL,
                            'will_expire' => $free_plan ? now()->addDays($free_plan->duration) : NULL,
                            'pictureUrl' => $request->pictureUrl ? $this->upload($request, 'pictureUrl') : NULL
                        ]);

            $user->update([
                'business_id' => $business->id,
                'phone' => $request->phoneNumber,
                'name' => $business->companyName,
            ]);

            $currency = Currency::where('is_default', 1)->first();
            UserCurrency::create([
                'business_id' => $business->id,
                'currency_id' => $currency->id,
                'name' => $currency->name,
                'country_name' => $currency->country_name,
                'code' => $currency->code,
                'rate' => $currency->rate,
                'symbol' => $currency->symbol,
                'position' => $currency->position,
            ]);

            if ($free_plan) {
                $subscribe = PlanSubscribe::create([
                                'plan_id' => $free_plan->id,
                                'business_id' => $business->id,
                                'duration' => $free_plan->duration,
                            ]);

                $business->update([
                    'plan_subscribe_id' => $subscribe->id,
                ]);
            }

            Cache::forget('plan-data-', $business->id);

            DB::commit();
            return response()->json([
                'message' => __('Business setup completed.'),
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(__('Something was wrong, Please contact with admin.'), 403);
        }
    }

    public function update(Request $request, Business $business)
    {
        $request->validate([
            'address' => 'nullable|max:250',
            'companyName' => 'required|max:250',
            'pictureUrl' => 'nullable|image|max:5120',
            'business_category_id' => 'required|exists:business_categories,id',
            'phoneNumber'  => ['nullable', 'min:5', 'max:15'],
        ]);

        auth()->user()->update([
            'name' => $request->companyName,
            'phone' => $request->phoneNumber,
        ]);

        $business->update($request->except('pictureUrl') + [
            'pictureUrl' => $request->pictureUrl ? $this->upload($request, 'pictureUrl', $business->pictureUrl) : $business->pictureUrl
        ]);

        Cache::forget('plan-data-', $business->id);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'business' => $business,
        ]);
    }
}
