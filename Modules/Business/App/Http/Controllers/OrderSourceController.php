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
            'account_name' => 'required|string',
            'name' => 'required|string|in:Shopify,YouCan,WooCommerce',
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
            'webhook_url' => 'required|url',
            'status' => 'required|boolean',
            'settings.shopify_store_url' => 'required_if:name,Shopify|url',
            'settings.woocommerce_store_url' => 'required_if:name,WooCommerce|url',
            'settings.youcan_store_url' => 'required_if:name,YouCan|url',
        ]);

        // Extract the specific store URL based on the platform
        $storeUrl = null;
        if ($request->name === 'Shopify') {
            $storeUrl = $request->input('settings.shopify_store_url');
        } elseif ($request->name === 'WooCommerce') {
            $storeUrl = $request->input('settings.woocommerce_store_url');
        } elseif ($request->name === 'YouCan') {
            $storeUrl = $request->input('settings.youcan_store_url');
        }

        $orderSource = OrderSource::create([
            'account_name' => $request->account_name,
            'name' => $request->name,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'webhook_url' => $request->webhook_url,
            'status' => $request->status,
            'settings' => $storeUrl, // Save the store URL as a plain string
        ]);

        return redirect()->route('business.orderSource.index')->with('success', 'Order Source created successfully!');
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
            'settings.shopify_store_url' => 'required_if:name,Shopify|url',
            'settings.woocommerce_store_url' => 'required_if:name,WooCommerce|url',
            'settings.youcan_store_url' => 'required_if:name,YouCan|url',
        ]);

        // Extract the specific store URL based on the platform
        $storeUrl = null;
        if ($request->name === 'Shopify') {
            $storeUrl = $request->input('settings.shopify_store_url');
        } elseif ($request->name === 'WooCommerce') {
            $storeUrl = $request->input('settings.woocommerce_store_url');
        } elseif ($request->name === 'YouCan') {
            $storeUrl = $request->input('settings.youcan_store_url');
        }

        $orderSource->update([
            'name' => $request->name,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'webhook_url' => $request->webhook_url,
            'status' => $request->status,
            'settings' => $storeUrl, // Save the store URL as a plain string
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
        // Define platform-specific headers
        $platformHeaders = [
            'Shopify' => 'X-Shopify-Hmac-Sha256',
            'YouCan' => 'X-YouCan-Signature',
            'WooCommerce' => 'X-WC-Webhook-Signature',
        ];

        // Get the header name for the platform
        $headerName = $platformHeaders[$orderSource->name] ?? 'X-Signature';

        // Retrieve the signature from the request header
        $signature = $request->header($headerName);
        if (!$signature) {
            \Log::warning('Missing signature header', ['platform' => $orderSource->name]);
            return false;
        }

        // Get the raw payload
        $payload = $request->getContent();

        // Generate the expected signature using the API secret
        $expectedSignature = hash_hmac('sha256', $payload, $orderSource->api_secret);

        // Compare the signatures
        return hash_equals($expectedSignature, $signature);
    }

    protected function parseOrderData($platform, $data)
    {
        switch ($platform) {
            case 'Shopify':
                return [
                    'business_id' => auth()->user()->business_id,
                    'party_id' => null,
                    'invoiceNumber' => $data['id'], 
                    'customer_name' => $data['customer']['first_name'] . ' ' . $data['customer']['last_name'],
                    'totalAmount' => $data['total_price'],
                    'dueAmount' => 0, 
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

    public function registerWebhook(OrderSource $orderSource)
    {
        switch ($orderSource->name) {
            case 'Shopify':
                return $this->registerShopifyWebhook($orderSource);
            case 'WooCommerce':
                return $this->registerWooCommerceWebhook($orderSource);
            case 'YouCan':
                return $this->registerYouCanWebhook($orderSource);
            default:
                return response()->json(['message' => 'Unsupported platform'], 400);
        }
    }

    protected function registerShopifyWebhook(OrderSource $orderSource)
    {
        $webhookUrl = $orderSource->webhook_url;

        // Directly use the settings field as the store URL
        $shopifyStoreUrl = $orderSource->settings;

        if (!$shopifyStoreUrl) {
            return response()->json(['message' => 'Shopify store URL is missing in settings'], 400);
        }

        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $orderSource->api_key,
        ])->post("https://{$shopifyStoreUrl}/admin/api/2023-01/webhooks.json", [
            'webhook' => [
                'topic' => 'orders/create',
                'address' => $webhookUrl,
                'format' => 'json',
            ],
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'Shopify webhook registered successfully']);
        }

        return response()->json(['message' => 'Failed to register Shopify webhook', 'error' => $response->body()], 400);
    }

    protected function registerWooCommerceWebhook(OrderSource $orderSource)
    {
        $webhookUrl = $orderSource->webhook_url;

        // Directly use the settings field as the store URL
        $woocommerceStoreUrl = $orderSource->settings;

        if (!$woocommerceStoreUrl) {
            return response()->json(['message' => 'WooCommerce store URL is missing in settings'], 400);
        }

        $response = Http::withBasicAuth($orderSource->api_key, $orderSource->api_secret)
            ->post("{$woocommerceStoreUrl}/wp-json/wc/v3/webhooks", [
                'name' => 'Order Created Webhook',
                'topic' => 'order.created',
                'delivery_url' => $webhookUrl,
                'status' => 'active',
            ]);

        if ($response->successful()) {
            return response()->json(['message' => 'WooCommerce webhook registered successfully']);
        }

        return response()->json(['message' => 'Failed to register WooCommerce webhook', 'error' => $response->body()], 400);
    }

    protected function registerYouCanWebhook(OrderSource $orderSource)
    {
        $webhookUrl = $orderSource->webhook_url;

        // Decode the settings JSON
        $settings = json_decode($orderSource->settings, true);

        // YouCan does not require additional settings in this example
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$orderSource->api_key}",
        ])->post("https://api.youcan.shop/v1/webhooks", [
            'url' => $webhookUrl,
            'event' => 'order.created',
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'YouCan webhook registered successfully']);
        }

        return response()->json(['message' => 'Failed to register YouCan webhook', 'error' => $response->body()], 400);
    }
}