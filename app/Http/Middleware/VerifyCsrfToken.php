<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/ssl-commerz/payment/success',
        '/ssl-commerz/payment/failed',
        'phonepe/status',
        '/paytm/status',
        'webhook/*',
        'otp-resend',
         'otp-submit',
    ];
}
