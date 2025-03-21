<?php

namespace App\Library;

use Stripe\Stripe;
use App\Models\Gateway;
use Illuminate\Http\Request;

class StripeGateway
{
    public static function make_payment($array)
    {
        $gateway = Gateway::findOrFail($array['gateway_id']);
        Stripe::setApiKey($gateway->data['stripe_secret']);
        $amount = $array['pay_amount'] * 100;

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => $array['billName'],
                        ],
                        'unit_amount'  => $amount,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url'  => route('payment.failed'),
        ]);

        return redirect()->away($session->url);
    }
}
