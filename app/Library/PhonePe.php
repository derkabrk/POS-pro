<?php
namespace App\Library;

use App\Models\Gateway;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Dipesh79\LaravelPhonePe\LaravelPhonePe;

class PhonePe
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
        //Checking Minimum/Maximum amount
        $gateway = Gateway::findOrFail($array['gateway_id']);
        $amount = $array['pay_amount'];

        $currency = $array['currency'];
        $email = $array['email'];
        $amount = round($array['pay_amount']);
        $name = $array['name'];
        $mode = $array['mode'];
        $billName = $array['billName'];
        $data['payment_mode'] = 'phonepe';

        $data['amount'] = $amount;
        $data['mode'] = $mode;
        $data['charge'] = $array['charge'];
        $data['main_amount'] = $array['amount'];
        $data['gateway_id'] = $array['gateway_id'];

        Session::put('phonepe_credentials', $data);

        $phonepe = new LaravelPhonePe();
        //amount, phone number, callback url, unique merchant transaction id
        $url = $phonepe->makePayment($amount, auth()->user()->phone, url('phonepe/status'), uniqid());
        return redirect()->away($url);
    }

    public function status(Request $request)
    {
        if (Session::has('phonepe_credentials')) {
            $order_info = Session::get('phonepe_credentials');

            $phonepe = new LaravelPhonePe();
            $response = $phonepe->getTransactionStatus($request->all());
            if($response == true) {
                $data['payment_method'] = "Phonepe";
                $data['gateway_id'] = $order_info['gateway_id'];
                $data['amount'] = $order_info['amount'];
                $data['billName'] = $order_info['billName'];
                $data['charge'] = $order_info['charge'];
                $data['status'] = 'completed';
                $data['payment_status'] = 'completed';
                $data['is_fallback'] = $order_info['is_fallback'];

                Session::put('payment_info', $data);
                Session::forget('phonepe_credentials');
                return request()->expectsJson() ?
                PhonePe::redirect_if_payment_success() :
                redirect(PhonePe::redirect_if_payment_success());
            } else {
                $data['payment_status'] = 'pending';
                Session::put('payment_info', $data);
                Session::forget('phonepe_credentials');

                return request()->expectsJson() ?
                PhonePe::redirect_if_payment_faild() :
                redirect(PhonePe::redirect_if_payment_faild());
            }
        }
    }
}
