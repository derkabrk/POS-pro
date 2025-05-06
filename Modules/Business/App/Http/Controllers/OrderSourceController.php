<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\OrderSource;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

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

    public function handleWebhook(Request $request, $platform)
    {
        // Validate the platform
        $orderSource = OrderSource::where('name', $platform)->first();
        if (!$orderSource) {
            return response()->json(['message' => 'Invalid platform'], 400);
        }

        // Verify the webhook signature (if applicable)
        if (!$this->verifyWebhookSignature($request, $orderSource)) {
            return response()->json(['message' => 'Invalid webhook signature'], 403);
        }

        // Parse the incoming order data
        $orderData = $this->parseOrderData($platform, $request->all());

        // Store the sale in the database
        $sale = Sale::create($orderData);

        return response()->json(['message' => 'Sale stored successfully', 'sale' => $sale], 200);
    }

    protected function verifyWebhookSignature(Request $request, $orderSource)
    {
        $signature = $request->header('X-Signature'); // Replace with the actual header used by the platform
        $payload = $request->getContent();

        // Generate the expected signature using the API secret
        $expectedSignature = hash_hmac('sha256', $payload, $orderSource->api_secret);

        return hash_equals($expectedSignature, $signature);
    }

    protected function parseOrderData($platform, $data)
    {
        switch ($platform) {
            case 'Shopify':
                return [
                    'business_id' => auth()->user()->business_id,
                    'party_id' => null, // Update if customer mapping exists
                    'invoiceNumber' => $data['id'], // Unique sale ID from Shopify
                    'customer_name' => $data['customer']['first_name'] . ' ' . $data['customer']['last_name'],
                    'totalAmount' => $data['total_price'],
                    'dueAmount' => 0, // Assuming full payment for now
                    'paidAmount' => $data['total_price'],
                    'sale_status' => $data['financial_status'],
                    'saleDate' => now(),
                    'meta' => json_encode($data), // Store raw sale data
                ];
            case 'YouCan':
                return [
                    'business_id' => auth()->user()->business_id,
                    'party_id' => null, // Update if customer mapping exists
                    'invoiceNumber' => $data['order_id'], // Unique sale ID from YouCan
                    'customer_name' => $data['customer']['name'],
                    'totalAmount' => $data['total'],
                    'dueAmount' => 0, // Assuming full payment for now
                    'paidAmount' => $data['total'],
                    'sale_status' => $data['status'],
                    'saleDate' => now(),
                    'meta' => json_encode($data), // Store raw sale data
                ];
            case 'WooCommerce':
                return [
                    'business_id' => auth()->user()->business_id,
                    'party_id' => null, // Update if customer mapping exists
                    'invoiceNumber' => $data['id'], // Unique sale ID from WooCommerce
                    'customer_name' => $data['billing']['first_name'] . ' ' . $data['billing']['last_name'],
                    'totalAmount' => $data['total'],
                    'dueAmount' => 0, // Assuming full payment for now
                    'paidAmount' => $data['total'],
                    'sale_status' => $data['status'],
                    'saleDate' => now(),
                    'meta' => json_encode($data), // Store raw sale data
                ];
            default:
                throw new \Exception('Unsupported platform');
        }
    }
}