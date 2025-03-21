<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Unit::where('business_id', auth()->user()->business_id)->latest()->get();

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
            'unitName' => 'required|unique:units,unitName,NULL,id,business_id,' . auth()->user()->business_id,
        ]);

        $data = Unit::create($request->all() + [
                    'business_id' => auth()->user()->business_id
                ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'unitName' => [
                'required',
                'unique:units,unitName,' . $unit->id . ',id,business_id,' . auth()->user()->business_id,
            ],
        ]);

        $unit = $unit->update($request->all());

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $unit,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}
