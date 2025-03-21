<?php

namespace App\Http\Controllers\Api;

use App\Models\Plan;
use App\Http\Controllers\Controller;

class AcnooSubscriptionsController extends Controller
{
    public function index()
    {
        $plans = Plan::whereStatus(1)->latest()->get();
        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $plans,
        ]);
    }
}
