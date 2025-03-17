<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $data = PaymentType::where('business_id', auth()->user()->business_id)->latest()->get();

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('payment_types')->where(function ($query) {
                    return $query->where('business_id', auth()->user()->business_id);
                }),
            ],
        ]);

        $data = PaymentType::create($request->all() + [
                'business_id' => auth()->user()->business_id
            ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $data,
        ]);
    }



    public function update(Request $request, string $id)
    {
        $payment_type = PaymentType::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:payment_types,name,' . $payment_type->id . ',id,business_id,' . auth()->user()->business_id,
        ]);

        $payment_type->update($request->all());

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $payment_type,
        ]);
    }

    public function destroy(string $id)
    {
        $payment_type = PaymentType::findOrFail($id);
        $payment_type->delete();
        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}
