<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\OrderSource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class OrderSourceController extends Controller
{
    /**
     * Display a listing of the order sources.
     */
    public function index()
    {
        // Fetch paginated order sources
        $orderSources = OrderSource::latest()->paginate(10); // Use paginate instead of get()

        // Manipulate data (e.g., concatenate name and status)
        $orderSources->getCollection()->transform(function ($orderSource) {
            $orderSource->display_name = $orderSource->name . ' (' . ($orderSource->status ? 'Active' : 'Inactive') . ')';
            return $orderSource;
        });

        // Pass data to the view
        return view('business::orderSource.index', compact('orderSources'));
    }


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

        $orderSource = OrderSource::create([
            'name' => $request->name,
            'api_key' => Hash::make($request->api_key), // Hash the API key
            'api_secret' => Hash::make($request->api_secret), // Hash the API secret
            'webhook_url' => $request->webhook_url,
            'status' => $request->status,
            'settings' => $request->settings,
        ]);

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
     * Show the form for editing the specified order source.
     */
    public function edit(OrderSource $orderSource)
    {
        return view('business::orderSource.edit', compact('orderSource'));
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

        $orderSource->update([
            'name' => $request->name,
            'api_key' => Hash::make($request->api_key), 
            'api_secret' => Hash::make($request->api_secret),
            'webhook_url' => $request->webhook_url,
            'status' => $request->status,
            'settings' => $request->settings,
        ]);

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