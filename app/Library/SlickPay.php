<?php

namespace App\Library;

use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SlickPay
{
    public static function make_payment($array)
    {
        // Retrieve the gateway details
        $gateway = Gateway::findOrFail($array['gateway_id']);
        $apiKey = $gateway->data['slickpay_api_key']; // Replace with the actual API key field
        $amount = $array['pay_amount'] * 100; // Convert to the smallest currency unit (e.g., cents)

        // Prepare the payment request payload
        $payload = [
            'amount' => $amount, // Required: Amount to transfer (must be greater than 100)
            'url' => self::redirect_if_payment_success(), // Required: Return URL after payment
        ];

        // Add the account UUID if provided
        if (!empty($array['account'])) {
            $payload['account'] = $array['account'];
        }

        // Add the contact UUID if provided
        if (!empty($array['contact'])) {
            $payload['contact'] = $array['contact'];
        } else {
            // If no contact is provided, use individual contact details
            if (!empty($array['rib'])) {
                $payload['rib'] = $array['rib'];
            }
            if (!empty($array['firstname'])) {
                $payload['firstname'] = $array['firstname'];
            }
            if (!empty($array['lastname'])) {
                $payload['lastname'] = $array['lastname'];
            }
            if (!empty($array['phone'])) {
                $payload['phone'] = $array['phone'];
            }
            if (!empty($array['email'])) {
                $payload['email'] = $array['email'];
            }
            if (!empty($array['address'])) {
                $payload['address'] = $array['address'];
            }
        }

        try {
            // Initialize cURL
            $cURL = curl_init();

            // Set cURL options
            curl_setopt($cURL, CURLOPT_URL, "https://prodapi.slick-pay.com/api/v2/users/transfers");
            curl_setopt($cURL, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($cURL, CURLOPT_HTTPHEADER, [
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer {$apiKey}",
            ]);
            curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURL, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($cURL, CURLOPT_TIMEOUT, 20);

            // Execute the cURL request
            $response = curl_exec($cURL);

            // Close the cURL session
            curl_close($cURL);

            // Parse the response
            $responseBody = json_decode($response, true);

            // Redirect the user to the payment page if a URL is provided
            if (isset($responseBody['payment_url'])) {
                return redirect()->away($responseBody['payment_url']);
            }

            // Handle unexpected response
            throw new \Exception('Unexpected response from SlickPay API.');
        } catch (\Exception $e) {
            // Log the error and redirect to the failure page
            \Log::error('SlickPay Payment Error:', ['error' => $e->getMessage()]);
            return redirect()->route('payment.failed')->with('error', __('Payment failed. Please try again.'));
        }
    }

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
}