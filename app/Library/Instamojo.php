<?php
namespace App\Library;

use App\Models\Gateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Instamojo
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
            return url('payment/instamojo');
        }
        return url('payment/instamojo');
    }

    public static function make_payment($array)
    {
        //Checking Minimum/Maximum amount
        $gateway = Gateway::findOrFail($array['gateway_id']);
        $amount = $array['pay_amount'];

        $regex = "/^(0|91|\+91)?[789]\d{9}$/";
        if ($array['phone'] == "") {
            return redirect()->back()->with('warning', 'Phone Number not given!')->with('type', 'alert-danger');
        }
        if (!preg_match($regex, $array['phone'])) {
            return redirect()->back()->with('warning', 'Phone Number not valid!')->with('type', 'alert-danger');
        }

        $currency = $array['currency'];
        $email = $array['email'];
        $amount = $array['pay_amount'];
        $name = $array['name'];
        $billName = $array['billName'];

        $mode = $array['mode'];

        $data['mode'] = $mode;

        $data['x_auth_token'] = $array['x_auth_token'];
        $data['x_api_key'] = $array['x_api_key'];
        $data['payment_mode'] = 'instamojo';
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
        Session::put('instamojo_credentials', $data);

        if ($mode == true) {
            $url = 'https://test.instamojo.com/api/1.1/payment-requests/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/payment-requests/';
        }

        try {
            $params = [
                'purpose' => $data['billName'],
                'amount' => $amount,
                'phone' => $data['phone'],
                'buyer_name' => $name,
                'redirect_url' => Instamojo::fallback(),
                'send_email' => true,
                'send_sms' => true,
                'email' => $email,
                'allow_repeated_payments' => false,
            ];
            $response = Http::asForm()->withHeaders([
                'X-Api-Key' => $data['x_api_key'],
                'X-Auth-Token' => $data['x_auth_token'],
            ])->post($url, $params);

            if (isset($response['payment_request'])) {
                $url = $response['payment_request']['longurl'];
                return redirect($url);
            } else {
                Session::flash('error', $response->reason());
                Session::forget('instamojo_credentials');
                return redirect(Instamojo::redirect_if_payment_faild());
            }
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            Session::forget('instamojo_credentials');
            return redirect(Instamojo::redirect_if_payment_faild());
        }
    }

    public function status()
    {
        if (!Session::has('instamojo_credentials')) {
            return abort(404);
        }
        $response = Request()->all();
        $payment_id = $response['payment_id'];
        $info = Session::get('instamojo_credentials');

        if ($response['payment_status'] == 'Credit') {
            $data['payment_id'] = $payment_id;
            $data['payment_method'] = "instamojo";
            $data['gateway_id'] = $info['gateway_id'];

            $data['amount'] = $info['main_amount'];
            $data['charge'] = $info['charge'];
            $data['status'] = 1;
            $data['payment_status'] = 1;

            Session::forget('instamojo_credentials');
            Session::put('payment_info', $data);

            return redirect(Instamojo::redirect_if_payment_success());
        } else {
            $data['payment_status'] = 0;
            Session::put('payment_info', $data);
            Session::forget('instamojo_credentials');
            return redirect(Instamojo::redirect_if_payment_faild());
        }
    }

    public static function isfraud($creds)
    {
        $payment_id = $creds['payment_id'];
        $api = $creds['x_api_key'];
        $is_test = $creds['is_test'];
        $auth_token = $creds['x_auth_token'];

        if ($is_test == 1) {
            $url = 'https://test.instamojo.com/api/1.1/payments/' . $payment_id . '/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/payments/' . $payment_id . '/';
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                array(
                    "Content-Type: application/json",
                    "X-Api-Key:" . $api,
                    "X-Auth-Token:" . $auth_token));
            $response = curl_exec($ch);
            curl_close($ch);
            $arr = json_decode($response, true);
            return $arr['success'] === true ? 1 : 0;
        } catch (\Throwable $th) {
            return 0;
        }

    }

}
