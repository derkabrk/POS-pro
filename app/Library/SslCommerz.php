<?php

namespace App\Library;

use App\Models\Gateway;
use App\Library\SslCommerz\SslCommerzNotification;

class SslCommerz
{
    public static function make_payment($array)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $gateway = Gateway::findOrFail($array['gateway_id']);

        $post_data = array();
        $post_data['total_amount'] = $array['pay_amount']; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '0564654156';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = $array['billName'];
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        $post_data['value_a'] = session('plan')->id ?? session('amount');
        $post_data['value_b'] = $gateway->id;
        $post_data['value_c'] = auth()->id();

        if ($array['payment_type'] == 'plan_payment') {
            $success_url = '/ssl-commerz/payment/success';
            $failed_url = '/ssl-commerz/payment/failed';
        } else {
            $success_url = '/ssl-commerz/recharge/success';
            $failed_url = '/ssl-commerz/recharge/failed';
        }

        $sslc = new SslCommerzNotification($gateway, $success_url, $failed_url);
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }
}
