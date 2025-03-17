<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Option;

class BusinessSettingController extends Controller
{
    public function index()
    {

        $data = Option::where('key', 'business-settings')
                        ->whereJsonContains('value->business_id', auth()->user()->business_id)
                        ->first();

        if ($data && isset($data->value['invoice_logo'])) {
            return response()->json([
                'message' => __('Data fetched successfully.'),
                'data' => $data->value['invoice_logo'],
            ]);
        } else {
            return response()->json([
                'message' => __('No matching record found.'),
                'data' => null,
            ], 404);
        }

    }

}
