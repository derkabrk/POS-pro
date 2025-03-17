<?php

namespace App\Http\Controllers\Api;

use App\Models\Income;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcnooIncomeController extends Controller
{
    public function index()
    {
        $data = Income::with('category:id,categoryName','payment_type:id,name')->where('business_id', auth()->user()->business_id)->latest()->get();

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'income_category_id' => 'required|exists:income_categories,id',
        ]);

        Business::findOrFail(auth()->user()->business_id)->decrement('remainingShopBalance', $request->amount);

        $data = Income::create($request->except('status') + [
                    'user_id' => auth()->id(),
                    'business_id' => auth()->user()->business_id,
                ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $data,
        ]);
    }
}
