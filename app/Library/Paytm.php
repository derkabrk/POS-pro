<?php

namespace App\Library;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use paytm\paytmchecksum\PaytmChecksum;
use Illuminate\Support\Facades\Session;

class Paytm
{
    public static function redirect_if_payment_success()
    {
        if (Session::has('fund_callback')) {
            return url(Session::get('fund_callback')['success_url']);
        } else {
            return url('payment/success');
        }
    }

    public static function redirect_if_payment_faild()
    {
        if (Session::has('fund_callback')) {
            return url(Session::get('fund_callback')['cancel_url']);
        } else {
            return url('payment/failed');
        }
    }

    public static function make_payment($array)
    {
        $user = auth()->user();

        $paytmParams = [
            "MID"             => $array['merchant_id'],
            "WEBSITE"         => $array['website'] ?? 'WEBSTAGING',
            "INDUSTRY_TYPE_ID"=> $array['industry_type'],
            "CHANNEL_ID"      => 'WEB',
            "ORDER_ID"        => rand(10000, 99999),
            "CUST_ID"         => $user->email,
            "TXN_AMOUNT"      => $array['pay_amount'],
            "CALLBACK_URL"    => route('paytm.status', ['email' => $user->email, 'merchant_key' => $array['merchant_key'], 'plan_id' => $array['plan_id'], 'gateway_id' => $array['gateway_id'], 'business_id' => $array['business_id'], 'platform' => $array['platform']]),
        ];

        // Generate the Checksum
        $paytmParams["CHECKSUMHASH"] = PaytmChecksum::generateSignature($paytmParams, $array['merchant_key']); // Replace with your Merchant Key

        // Paytm transaction URL
        $paytmUrl = $array['mode'] == 'Live' ? "https://securegw.paytm.in/theia/processTransaction" : "https://securegw-stage.paytm.in/theia/processTransaction";

        // Pass data to the blade view
        return view('payments.paytm', compact('paytmParams', 'paytmUrl'));
    }

    public function status(Request $request)
    {
        // Capture callback data
        $paytmParams = $request->all();

        $user = User::where('email', request('email'))->first();
        Auth::login($user);

        session()->put('plan_id', request('plan_id'));
        session()->put('platform', request('platform'));
        session()->put('gateway_id', request('gateway_id'));
        session()->put('business_id', request('business_id'));

        // Verify the checksum
        if (!isset($paytmParams['CHECKSUMHASH'])) {
            // Payment failed logic
            session()->put('payment_msg', __('Invalid checksum, Please verify your credentials or contact with paytm support.'));
            return redirect(Paytm::redirect_if_payment_faild());
        }

        $isValidChecksum = PaytmChecksum::verifySignature($paytmParams, request('merchant_key'), $paytmParams['CHECKSUMHASH']); // Replace with your Merchant Key

        if ($isValidChecksum && $paytmParams['STATUS'] === 'TXN_SUCCESS') {
            return redirect(Paytm::redirect_if_payment_success());
        }

        // Payment failed logic
        session()->put('payment_msg', $paytmParams['RESPMSG']);
        return redirect(Paytm::redirect_if_payment_faild());
    }
}
