<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\OrderSource;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderSourceController extends Controller
{
    /**
     * Display a listing of the order sources.
     */
    public function index()
    {
        // Fetch paginated order sources
        $orderSources = OrderSource::latest()->paginate(10);

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
            'api_secret' => 'nullable|string',
            'shopify_store_url' => 'nullable|required_if:name,Shopify|regex:/^(https?:\/\/)?[a-zA-Z0-9\-]+\.myshopify\.com$/',
            'woocommerce_store_url' => 'nullable|required_if:name,WooCommerce|url',
            'youcan_store_url' => 'nullable|required_if:name,YouCan|url',
            'status' => 'required|boolean',
        ]);

        $settings = [];
        if ($request->name === 'Shopify') {
            $settings['shop_domain'] = preg_replace('/^https?:\/\//', '', $request->shopify_store_url);
        } elseif ($request->name === 'WooCommerce') {
            $settings['store_url'] = $request->woocommerce_store_url;
        } elseif ($request->name === 'YouCan') {
            $settings['store_url'] = $request->youcan_store_url;
        }

        $orderSource = OrderSource::create([
            'account_name' => $request->account_name,
            'name' => $request->name,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'webhook_url' => $request->webhook_url,
            'status' => $request->status,
            'settings' => json_encode($settings),
        ]);

        // Explicitly register the webhook
        $this->registerWebhook($orderSource);

        return redirect()->route('business.orderSource.index')->with('success', 'Order Source created successfully.');
    }

    public function show(OrderSource $orderSource)
    {
        return response()->json([
            'message' => __('Order source fetched successfully.'),
            'data' => $orderSource,
        ]);
    }

    public function edit(OrderSource $orderSource)
    {
        return view('business::orderSource.edit', compact('orderSource'));
    }

    public function update(Request $request, OrderSource $orderSource)
    {
        $request->validate([
            'account_name' => 'required|string',
            'name' => 'required|string|in:Shopify,YouCan,WooCommerce',
            'api_key' => 'required|string',
            'api_secret' => 'nullable|string',
            'webhook_url' => 'required|url',
            'status' => 'required|boolean',
            'shopify_store_url' => 'nullable|required_if:name,Shopify|regex:/^(https?:\/\/)?[a-zA-Z0-9\-]+\.myshopify\.com$/',
            'woocommerce_store_url' => 'required_if:name,WooCommerce|url',
            'youcan_store_url' => 'required_if:name,YouCan|url',
        ]);

        // Extract the specific store URL based on the platform
        $storeUrl = null;
        if ($request->name === 'Shopify') {
            $storeUrl = $request->shopify_store_url;
        } elseif ($request->name === 'WooCommerce') {
            $storeUrl = $request->woocommerce_store_url;
        } elseif ($request->name === 'YouCan') {
            $storeUrl = $request->youcan_store_url;
        }

        $orderSource->update([
            'account_name' => $request->account_name,
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

    public function destroy(OrderSource $orderSource)
    {
        $orderSource->delete();

        return response()->json([
            'message' => __('Order source deleted successfully.'),
        ]);
    }

    public function handleWebhook(Request $request, $platform)
    {
        // Find the OrderSource by platform name
        $orderSource = OrderSource::where('name', $platform)->first();

        if (!$orderSource) {
            return response()->json(['message' => 'Invalid platform'], 400);
        }

        // Verify the webhook signature
        if (!$this->verifyWebhookSignature($request, $orderSource)) {
            return response()->json(['message' => 'Invalid webhook signature'], 403);
        }

        // Parse the order data based on the platform
        $orderData = $this->parseOrderData($platform, $request->all());

        // Add the order_source_id to the order data
        $orderData['order_source_id'] = $orderSource->id;

        // Create the Sale record
        $sale = Sale::create($orderData);

        return response()->json(['message' => 'Sale stored successfully', 'sale' => $sale], 200);
    }

    protected function verifyWebhookSignature(Request $request, $orderSource)
    {
        $platformHeaders = [
            'Shopify' => 'X-Shopify-Hmac-Sha256',
            'YouCan' => 'X-YouCan-Signature',
            'WooCommerce' => 'X-WC-Webhook-Signature',
        ];

        $headerName = $platformHeaders[$orderSource->name] ?? 'X-Signature';
        $payload = $request->getContent();
        $signature = $request->header($headerName);

        if (empty($signature) || empty($orderSource->api_secret)) {
            Log::warning('Missing signature or API secret', [
                'signature' => $signature,
                'api_secret' => $orderSource->api_secret,
                'platform' => $orderSource->name,
            ]);
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $payload, $orderSource->api_secret, $orderSource->name === 'Shopify');
        return hash_equals($expectedSignature, $signature);
    }

    protected function parseOrderData($platform, $data)
    {
        switch ($platform) {
            case 'Shopify':
                $customer = is_array($data['customer'] ?? null) ? $data['customer'] : [];
                return [
                    'business_id' => auth()->user()->business_id,
                    'party_id' => null,
                    'invoiceNumber' => $data['id'] ?? null,
                    'customer_name' => ($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? ''),
                    'totalAmount' => $data['total_price'] ?? 0,
                    'dueAmount' => 0,
                    'paidAmount' => $data['total_price'] ?? 0,
                    'sale_status' => $data['financial_status'] ?? 'unknown',
                    'saleDate' => now(),
                    'meta' => json_encode($data),
                ];

            case 'YouCan':
                $customer = is_array($data['customer'] ?? null) ? $data['customer'] : [];
                return [
                    'business_id' => auth()->user()->business_id,
                    'party_id' => null,
                    'invoiceNumber' => $data['order_id'] ?? null,
                    'customer_name' => $customer['name'] ?? '',
                    'totalAmount' => $data['total'] ?? 0,
                    'dueAmount' => 0,
                    'paidAmount' => $data['total'] ?? 0,
                    'sale_status' => $data['status'] ?? 'unknown',
                    'saleDate' => now(),
                    'meta' => json_encode($data),
                ];

            case 'WooCommerce':
                $billing = is_array($data['billing'] ?? null) ? $data['billing'] : [];
                return [
                    'business_id' => auth()->user()->business_id,
                    'party_id' => null,
                    'invoiceNumber' => $data['id'] ?? null,
                    'customer_name' => ($billing['first_name'] ?? '') . ' ' . ($billing['last_name'] ?? ''),
                    'totalAmount' => $data['total'] ?? 0,
                    'dueAmount' => 0,
                    'paidAmount' => $data['total'] ?? 0,
                    'sale_status' => $data['status'] ?? 'unknown',
                    'saleDate' => now(),
                    'meta' => json_encode($data),
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
        $settings = json_decode($orderSource->settings, true); // Decode settings into an array

        if (!isset($settings['shop_domain'])) {
            return response()->json(['message' => 'Shopify store URL is missing in settings'], 400);
        }

        $shopifyStoreUrl = $settings['shop_domain'];

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

    protected function createShopifyWebhook()
    {
        $settings = $this->settings;

        if (!isset($settings['shop_domain'])) {
            \Log::error('Shopify settings are missing the shop_domain key.');
            return;
        }

        $shopDomain = $settings['shop_domain'];
        $shopUrl = "https://{$shopDomain}"; // Ensure the URL starts with https://

        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->api_key,
        ])->post("{$shopUrl}/admin/api/2023-01/webhooks.json", [
            'webhook' => [
                'topic' => 'orders/create',
                'address' => $this->webhook_url,
                'format' => 'json',
            ],
        ]);

        if ($response->failed()) {
            \Log::error('Failed to create Shopify webhook: ' . $response->body());
        }
    }
}