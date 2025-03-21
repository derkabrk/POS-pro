<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcnooExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Expense::with('category:id,categoryName','payment_type:id,name')->where('business_id', auth()->user()->business_id)->latest()->get();

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
            'expense_category_id' => 'required|exists:expense_categories,id',
        ]);

        Business::findOrFail(auth()->user()->business_id)->decrement('remainingShopBalance', $request->amount);

        $data = Expense::create($request->except('status') + [
                    'user_id' => auth()->id(),
                    'business_id' => auth()->user()->business_id,
                ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $data,
        ]);
    }
}
