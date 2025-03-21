<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use App\Http\Controllers\Controller;

class AcnooTermsController extends Controller
{
    public function index()
    {
        $term = Option::where('key', 'term')->first()->value;
        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $term ?? 'Terms & Conditions.',
        ]);
    }
}
