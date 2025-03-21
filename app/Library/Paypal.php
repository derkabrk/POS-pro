<?php
namespace App\Library;

use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;

class Paypal
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
            return url('payment/paypal');
        }
        return url('payment/paypal');
    }

    public static function make_payment($array)
    {
        //Checking Minimum/Maximum amount
        $gateway = Gateway::findOrFail($array['gateway_id']);
        $amount = $array['pay_amount'];

        $client_id = $array['client_id'];
        $client_secret = $array['client_secret'];
        $currency = $array['currency'];
        $email = $array['email'];
        $amount = round($array['pay_amount']);
        $name = $array['name'];
        $mode = $array['mode'];
        $billName = $array['billName'];
        $data['client_id'] = $client_id;
        $data['client_secret'] = $client_secret;
        $data['payment_mode'] = 'paypal';

        $data['amount'] = $amount;
        $data['mode'] = $mode;
        $data['charge'] = $array['charge'];
        $data['main_amount'] = $array['amount'];
        $data['gateway_id'] = $array['gateway_id'];
        $data['payment_type'] = $array['payment_type'] ?? '';

        if ($mode == 0) {
            $data['env'] = false;
            $mode = false;
            $final = str_replace(',', '', number_format($amount, 3));
        } else {
            $data['env'] = true;
            $mode = true;
            $final = str_replace(',', '', number_format($amount / 100, 3));
        }

        Session::put('paypal_credentials', $data);
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->setClientId($client_id);
        $gateway->setSecret($client_secret);
        $gateway->setTestMode($mode);

        $response = $gateway->purchase(array(
            'amount' => $final,
            'currency' => strtoupper($currency),
            'returnUrl' => Paypal::fallback(),
            'cancelUrl' => Paypal::redirect_if_payment_faild(),
        ))->send();

        if ($response->isRedirect()) {
            if (request()->expectsJson()) {
                return $response->getRedirectUrl();
            }
            $response->redirect(); // this will automatically forward the customer
        } else {
            // not successful

            return request()->expectsJson() ?
            Paypal::redirect_if_payment_faild() :
            redirect(Paypal::redirect_if_payment_faild());
        }
    }

    public function status(Request $request)
    {
        abort_if(!Session::has('paypal_credentials'), 404);

        $credentials = Session::get('paypal_credentials');
        $gateway = Omnipay::create('PayPal_Rest');
        $gateway->setClientId($credentials['client_id']);
        $gateway->setSecret($credentials['client_secret']);
        $gateway->setTestMode($credentials['env']);

        $request = $request->all();

        $transaction = $gateway->completePurchase(array(
            'payer_id' => $request['PayerID'],
            'transactionReference' => $request['paymentId'],
        ));

        $response = $transaction->send();
        if ($response->isSuccessful()) {
            $arr_body = $response->getData();
            $data['payment_id'] = $arr_body['id'];
            $data['payment_method'] = "paypal";
            $data['gateway_id'] = $credentials['gateway_id'];

            $data['amount'] = $credentials['main_amount'];
            $data['charge'] = $credentials['charge'];
            $data['status'] = 1;
            $data['payment_status'] = 1;

            Session::put('payment_info', $data);
            Session::forget('paypal_credentials');

            return request()->expectsJson() ?
            Paypal::redirect_if_payment_success() :
            redirect(Paypal::redirect_if_payment_faild());
        } else {
            $data['payment_status'] = 0;
            Session::put('payment_info', $data);
            Session::forget('paypal_credentials');

            return request()->expectsJson() ?
            Paypal::redirect_if_payment_faild() :
            redirect(Paypal::redirect_if_payment_faild());
        }
    }
}
