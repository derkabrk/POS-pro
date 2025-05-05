<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\OrderSource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderSourceController extends Controller
{
    /**
     * Display a listing of the order sources.
     */
    public function index()
    {
        $orderSources = OrderSource::latest()->paginate(20);

        return response()->json([
            'message' => __('Order sources fetched successfully.'),
            'data' => $orderSources,
        ]);
    }

    /**
     * Show the form for creating a new order source.
     */
    public function create()
    {
        return view('business::orderSource.create');
    }

    /**
     * Store a newly created order source in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:order_sources,name',
            'api_key' => 'required|string|max:255',
            'api_secret' => 'required|string|max:255',
            'webhook_url' => 'nullable|url',
            'status' => 'required|boolean',
            'settings' => 'nullable|json',
        ]);

        $orderSource = OrderSource::create($request->all());

        return response()->json([
            'message' => __('Order source created successfully.'),
            'data' => $orderSource,
        ]);
    }

    /**
     * Display the specified order source.
     */
    public function show(OrderSource $orderSource)
    {
        return response()->json([
            'message' => __('Order source fetched successfully.'),
            'data' => $orderSource,
        ]);
    }

    /**
     * Update the specified order source in storage.
     */
    public function update(Request $request, OrderSource $orderSource)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:order_sources,name,' . $orderSource->id,
            'api_key' => 'required|string|max:255',
            'api_secret' => 'required|string|max:255',
            'webhook_url' => 'nullable|url',
            'status' => 'required|boolean',
            'settings' => 'nullable|json',
        ]);

        $orderSource->update($request->all());

        return response()->json([
            'message' => __('Order source updated successfully.'),
            'data' => $orderSource,
        ]);
    }

    /**
     * Remove the specified order source from storage.
     */
    public function destroy(OrderSource $orderSource)
    {
        $orderSource->delete();

        return response()->json([
            'message' => __('Order source deleted successfully.'),
        ]);
    }
}