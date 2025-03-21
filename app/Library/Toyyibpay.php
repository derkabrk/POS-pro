<?php
namespace App\Library;

use App\Models\Gateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Str;
use Throwable;

class Toyyibpay
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

    public static function fallback()
    {
        if (Session::get('without_auth')) {
            return url('payment/toyyibpay');
        }
        return url('payment/toyyibpay');
    }

    public static function make_payment($array)
    {
        //Checking Minimum/Maximum amount
        $gateway = Gateway::findOrFail($array['gateway_id']);
        $amount = $array['pay_amount'];

        $currency = $array['currency'];
        $email = $array['email'];
        $amount = $array['pay_amount'];
        $name = $array['name'];
        $billName = $array['billName'];
        $mode = $array['mode'];
        $data['mode'] = $mode;

        $data['user_secret_key'] = $array['user_secret_key'];
        $data['cateogry_code'] = $array['cateogry_code'];
        $data['payment_mode'] = 'toyyibpay';
        $data['amount'] = $amount;
        $data['charge'] = $array['charge'];
        $data['phone'] = $array['phone'];
        $data['gateway_id'] = $array['gateway_id'];
        $data['main_amount'] = $array['amount'];

        $data['billName'] = $billName;
        $data['name'] = $name;
        $data['email'] = $email;
        $data['currency'] = $currency;

        if ($mode == 0) {
            $data['env'] = false;
            $mode = false;
        } else {
            $data['env'] = true;
            $mode = true;
        }

        Session::put('toyyibpay_credentials', $data);

        if ($mode == false) {
            $url = 'https://toyyibpay.com/';
        } else {
            $url = 'https://dev.toyyibpay.com/';
        }

        $data = array(
            'userSecretKey' => $array['user_secret_key'],
            'categoryCode' => $array['cateogry_code'],
            'billName' => $billName,
            'billDescription' => "Thank you for order",
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $amount * 100,
            'billReturnUrl' => Toyyibpay::fallback(),
            'billCallbackUrl' => Toyyibpay::fallback(),
            'billExternalReferenceNo' => Str::random(5) . rand(100, 200),
            'billTo' => $name,
            'billEmail' => $email,
            'billPhone' => $array['phone'],
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => '2',
            'billDisplayMerchant' => 1,
            'billContentEmail' => "",
            'billChargeToCustomer' => 2,
        );
        $f_url = $url . 'index.php/api/createBill';

        try {
            $response = Http::asForm()->post($f_url, $data);
            $billcode = $response[0]['BillCode'];
            $url = $url . $billcode;
            return request()->expectsJson() ? $url : redirect($url);
        } catch (Throwable $th) {
            return request()->expectsJson() ?
            Toyyibpay::redirect_if_payment_faild() :
            redirect(Toyyibpay::redirect_if_payment_faild());
        }
    }

    public function status()
    {
        if (!Session::has('toyyibpay_credentials')) {
            return abort(404);
        }
        $response = Request()->all();
        $status = $response['status_id'];
        $payment_id = $response['billcode'];

        $info = Session::get('toyyibpay_credentials');

        if ($status == 1) {
            $data['payment_id'] = $payment_id;
            $data['payment_method'] = "toyyibpay";
            $data['gateway_id'] = $info['gateway_id'];

            $data['amount'] = $info['main_amount'];
            $data['charge'] = $info['charge'];
            $data['status'] = 1;
            $data['payment_status'] = 1;

            Session::forget('toyyibpay_credentials');
            Session::put('payment_info', $data);

            return request()->expectsJson() ?
            Toyyibpay::redirect_if_payment_success() :
            redirect(Toyyibpay::redirect_if_payment_success());
        } else {
            $data['payment_status'] = 0;
            Session::put('payment_info', $data);
            Session::forget('toyyibpay_credentials');

            return request()->expectsJson() ?
            Toyyibpay::redirect_if_payment_faild() :
            redirect(Toyyibpay::redirect_if_payment_faild());
        }
    }
}
