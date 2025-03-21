<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Gateway;
use App\Models\Business;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use App\Models\PlanSubscribe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    use HasUploader;
    /**
     * Display a listing of the resource.
    */
    public function index($id, $business_id)
    {
        $plan = Plan::findOrFail($id);
        session()->put('business_id', $business_id);
        session()->put('platform', request('platform') ?? 'web');
        $business = Business::findOrFail(session("business_id"));
        $plan_data = plan_data($business_id);

        if (($plan_data ?? false) && ($plan_data->plan_id == $plan->id && $business->will_expire > now()->addDays(7)) ||
            ($business->will_expire >= now()->addDays($plan->duration))) {

            return redirect(route('business.subscriptions.index'))->with('message', __('You have already subscribed to this plan. Please try again after - '. formatted_date($business->will_expire)));
        }

        $gateways = Gateway::with('currency:id,code,rate,symbol,position')->where('status', 1)->get();

        return view('payments.index', compact('gateways', 'plan'));
    }

    /**
     * Store a newly created resource in storage.
    */
    public function payment(Request $request, $plan_id, $gateway_id)
    {
        $request->validate([
            'phone' => 'max:15|min:5',
        ]);

        $plan = Plan::findOrFail($plan_id);
        $gateway = Gateway::findOrFail($gateway_id);
        $business = Business::findOrFail(session("business_id"));

        if ($gateway->is_manual) {
            $request->validate([
                'attachment' => 'required|mimes:jpg,jpeg,png|max:2048|file',
            ]);

            DB::beginTransaction();
            try {

                $has_free_subscriptions = Plan::where('subscriptionPrice', '<=', 0)->orWhere('offerPrice', '<=', 0)->first();

                if ($plan->subscriptionPrice <= 0 && $has_free_subscriptions) {
                    return response()->json([
                        'status' => 406,
                        'message' => __('Sorry, you cannot subscribe to a free plan again.'),
                    ], 406);
                }

                $attachment = $request->attachment ? $this->upload($request, 'attachment') : NULL;

                $subscribe = PlanSubscribe::create([
                    'plan_id' => $plan->id,
                    'duration' => $plan->duration,
                    'business_id' => $business->id,
                    'price' => $plan->subscriptionPrice,
                    'gateway_id' => $gateway_id,
                    'payment_status' => 'unpaid',
                    'notes' => [
                        'manual_data' => $request->manual_data,
                        'attachment' => $attachment
                    ],
                ]);

                sendNotification($subscribe->id, route('admin.subscription-reports.index', ['id' => $subscribe->id]), __('New subscription purchased requested.'));

                DB::commit();
                return redirect(route('order.status', ['status' => 'success']))->with('message', __('New subscription purchased requested.'));

            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('order.status', ['status' => 'failed']))->with('message', __('Something went wrong!'));
            }
        }

        $amount = $plan->offerPrice ?? $plan->subscriptionPrice;

        if ($gateway->namespace == 'App\Library\SslCommerz') {
            Session::put('fund_callback.success_url', '/ssl-commerz//payment/success');
            Session::put('fund_callback.cancel_url', '/ssl-commerz//payment/failed');
        } else {
            Session::put('fund_callback.success_url', '/payment/success');
            Session::put('fund_callback.cancel_url', '/payment/failed');
        }

        $payment_data['currency'] = $gateway->currency->code ?? 'USD';
        $payment_data['email'] = auth()->user()->email ?? $business->companyName;
        $payment_data['name'] = $business->companyName;
        $payment_data['phone'] = $request->phone ?? $business->phoneNumber;
        $payment_data['billName'] = __('Make plan purchase payment');
        $payment_data['amount'] = $amount;
        $payment_data['mode'] = $gateway->mode;
        $payment_data['charge'] = $gateway->charge ?? 0;
        $payment_data['pay_amount'] = round(convert_money($amount, $gateway->currency) + $gateway->charge);
        $payment_data['gateway_id'] = $gateway->id;
        $payment_data['payment_type'] = 'plan_payment';
        $payment_data['request_from'] = 'merchant';
        $payment_data['plan_id'] = $plan_id;
        $payment_data['business_id'] = $business->id;
        $payment_data['platform'] = session('platform');

        foreach ($gateway->data ?? [] as $key => $info) {
            $payment_data[$key] = $info;
        }

        session()->put('gateway_id', $gateway->id);
        session()->put('plan', $plan);

        $redirect = $gateway->namespace::make_payment($payment_data);
        return $redirect;
    }

    public function success()
    {
        DB::beginTransaction();
        try {

            $plan = session('plan');
            $gateway_id = session('gateway_id');

            if (!$plan && !session('plan_id')) {
                return redirect(route('order.status', ['status' => 'failed']))->with('error', __('Transaction failed, Please try again.'));
            }

            if (session('plan_id') && !$plan) {
                $plan = Plan::findOrFail(session('plan_id'));
            }

            $business = Business::findOrFail(session("business_id"));
            $has_free_subscriptions = Plan::where('subscriptionPrice', '<=', 0)->orWhere('offerPrice', '<=', 0)->first();

            if ($plan->subscriptionName == 'Free' && $has_free_subscriptions) {
                return response()->json([
                    'status' => 406,
                    'message' => __('Sorry, you cannot subscribe to a free plan again.'),
                ], 406);
            }

            $subscribe = PlanSubscribe::create([
                            'plan_id' => $plan->id,
                            'duration' => $plan->duration,
                            'business_id' => $business->id,
                            'price' => $plan->subscriptionPrice,
                            'gateway_id' => $gateway_id,
                            'payment_status' => 'paid',
                        ]);

            $business->update([
                'subscriptionDate' => now(),
                'plan_subscribe_id' => $subscribe->id,
                'will_expire' => now()->addDays($plan->duration),
            ]);

            session()->forget('plan');
            session()->forget('plan_id');
            session()->forget('gateway_id');
            session()->forget('business_id');
            Cache::forget('plan-data-', $business->id);

            DB::commit();
            return redirect(route('order.status', ['status' => 'success']))->with('message', __('New subscription order successfully.'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('order.status', ['status' => 'failed']))->with('message', __('Something went wrong!'));
        }
    }

    public function failed()
    {
        $payment_msg = session('payment_msg');
        session()->forget('payment_msg');
        return redirect(route('business.subscriptions.index'))->with('error', $payment_msg ?? __('Transaction failed, Please try again.'));
    }

    public function sslCommerzSuccess(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!$request->value_a || !$request->value_b || !$request->value_c) {
                return redirect(route('order.status', ['status' => 'failed']))->with('error', __('Transaction failed, Please try again.'));
            }

            $plan = session('plan');
            $gateway_id = session('gateway_id');
            if (!$plan) {
                return redirect(route('order.status', ['status' => 'failed']))->with('error', __('Transaction failed, Please try again.'));
            }

            $business = Business::findOrFail(session("business_id"));
            $has_free_subscriptions = Plan::where('subscriptionPrice', '<=', 0)->orWhere('offerPrice', '<=', 0)->first();

            if ($plan->subscriptionPrice <= 0 && $has_free_subscriptions) {
                return response()->json([
                    'status' => 406,
                    'message' => __('Sorry, you cannot subscribe to a free plan again.'),
                ], 406);
            }

            $subscribe = PlanSubscribe::create([
                            'plan_id' => $plan->id,
                            'duration' => $plan->duration,
                            'business_id' => $business->id,
                            'price' => $plan->subscriptionPrice,
                            'gateway_id' => $gateway_id,
                            'payment_status' => 'paid',
                        ]);

            $business->update([
                'subscriptionDate' => now(),
                'plan_subscribe_id' => $subscribe->id,
                'will_expire' => now()->addDays($plan->duration),
            ]);

            session()->forget('gateway_id');
            session()->forget('plan');
            Cache::forget('plan-data-', $business->id);

            DB::commit();
            return redirect(route('order.status', ['status' => 'success']))->with('message', __('New subscription order successfully.'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('order.status', ['status' => 'failed']))->with('message', __('Something went wrong!'));
        }
    }

    public function sslCommerzFailed()
    {
        return redirect(route('order.status', ['status' => 'failed']))->with('error', __('Transaction failed, Please try again.'));
    }

    public function orderStatus()
    {
        if (session('platform') == 'web') {
            return redirect(route('business.subscriptions.index'))->with('message', request('message') ?? __('New subscription order successfully.'));;
        }
        session()->forget('platform');
        return request('status');
    }
}
