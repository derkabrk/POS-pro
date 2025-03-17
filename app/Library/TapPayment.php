<?php

namespace App\Library;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TapPayment
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
        $data = [
            'amount' => $array['pay_amount'],
            'currency' => $array['currency'] ?? 'SAR',
            'threeDSecure' => true,
            'save_card' => false,
            'description' => $array['billName'],
            'customer' => [
                'first_name' => $array['name'],
                'email' => $array['email'],
            ],
            'source' => [
                'id' => 'src_all',
            ],
            'redirect' => [
                'url' => route('tap-payment.status'),
            ],
        ];

        try {
            $client = new Client(['base_uri' => 'https://api.tap.company/v2/']);
            $response = $client->post('charges', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $array['secret_key'],
                    'Content-Type'  => 'application/json',
                ],
                'json' => $data,
            ]);

            session()->put('secret_key', $array['secret_key']);

            $responseBody = json_decode($response->getBody(), true);

            // Redirect the user to Tap's payment page
            return redirect($responseBody['transaction']['url']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function status(Request $request)
    {
        // Extract the parameters from the request
        $paymentId = $request->query('tap_id'); // Tap Payment ID

        if (!$paymentId) {
            return response()->json(['error' => 'Invalid callback response'], 400);
        }

        try {
            // Verify the payment status using the Tap API
            $client = new \GuzzleHttp\Client();
            $response = $client->get('https://api.tap.company/v2/' . 'charges/' . $paymentId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('secret_key'),
                ],
            ]);

            $paymentDetails = json_decode($response->getBody(), true);
            session()->forget('secret_key');

            // Check the status
            if ($paymentDetails['status'] === 'CAPTURED') {
                return redirect(TapPayment::redirect_if_payment_success());
            } else {
                session()->put('payment_msg', $paymentDetails['response']['message']);
                return redirect(TapPayment::redirect_if_payment_faild());
            }
        } catch (\Exception $e) {
            session()->put('payment_msg', $e->getMessage());
            return redirect(TapPayment::redirect_if_payment_faild());
        }
    }
}
