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
        'api_key' => 'required_if:name,Shopify|string|nullable',
        'api_secret' => 'required_if:name,Shopify|string|nullable',
        'shopify_store_url' => 'nullable|required_if:name,Shopify|regex:/^(https?:\/\/)?[a-zA-Z0-9\-]+\.myshopify\.com$/',
        'status' => 'required|boolean',
    ]);

    // Handle Shopify platform
    if ($request->name === 'Shopify') {

        $shop = preg_replace('/^https?:\/\//', '', $request->shopify_store_url); // Remove http:// or https://
       // $apiKey = $request->input('api_key');
       $apiKey = config('services.shopify.api_key');
        $apiSecret = $request->input('api_secret');
        $redirectUri = route('business.shopify.callback'); // OAuth callback
        $scopes = 'read_orders,write_orders,read_products';

        $oauthUrl = "https://{$shop}/admin/oauth/authorize?" . http_build_query([
            'client_id' => $apiKey,
            'scope' => $scopes,
            'redirect_uri' => $redirectUri,
        ]);

        // Save Shopify info temporarily in session for use after OAuth
        session([
            'shopify_store_url' => $shop,
            'account_name' => $request->account_name,
            'status' => $request->status,
            'api_key' => $apiKey,
            'api_secret' => $apiSecret,
        ]);

        // Redirect to Shopify for OAuth (no AJAX/fetch!)
        return redirect()->away($oauthUrl);
    }

    // For other platforms like WooCommerce or YouCan
    $settings = [];

    $orderSource = OrderSource::create([
        'business_id' => auth()->user()->business_id,
        'user_id' => auth()->id(),
        'account_name' => $request->account_name,
        'name' => $request->name,
        'api_key' => $request->api_key,
        'api_secret' => $request->api_secret,
        'status' => $request->status,
        'settings' => $settings,
    ]);

    return redirect()
        ->route('business.orderSource.index')
        ->with('success', __('Order source created successfully.'));
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

        $settings = [];
        if ($request->name === 'Shopify') {
            $settings['shop_domain'] = preg_replace('/^https?:\/\//', '', $request->shopify_store_url); // Remove http:// or https://
        }

        $orderSource->update([
            'account_name' => $request->account_name,
            'name' => $request->name,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'webhook_url' => $request->webhook_url,
            'status' => $request->status,
            'settings' => json_encode($settings),
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => __('Order source updated successfully.'),
            'data' => $orderSource,
        ]);
    }

    ////get 

    public function destroy(OrderSource $orderSource)
    {
        // Delete the OrderSource
        $orderSource->delete();

        // Redirect the user to the index page with a success message
        return redirect()->route('business.orderSource.index')->with('success', __('Order source deleted successfully.'));
    }

    public function handleWebhook(Request $request, $platform)
    {
        
        $orderSource = OrderSource::where('name', $platform)->first();

        if (!$orderSource) {
            return response()->json(['message' => 'Invalid platform'], 400);
        }

       
        if (!$this->verifyWebhookSignature($request, $orderSource)) {
            return response()->json(['message' => 'Invalid webhook signature'], 403);
        }

        
        $payload = $request->all();

        
        $businessId = $orderSource->business_id;

        if (!$businessId) {
            \Log::error('business_id is missing in the OrderSource:', ['orderSource' => $orderSource]);
            return response()->json(['message' => 'business_id is missing in the OrderSource'], 400);
        }

       
        $orderData = $this->parseOrderData($platform, $payload, $orderSource);
 
        
        $orderData['order_source_id'] = $orderSource->id;
        $orderData['business_id'] = $businessId;
        $orderData['user_id'] = $orderSource->user_id;

        
        \Log::info('Creating Sale with data:', $orderData);

        
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
            \Log::warning('Missing signature or API secret', [
                'signature' => $signature,
                'api_secret' => $orderSource->api_secret,
                'platform' => $orderSource->name,
            ]);
            return false;
        }

        $expectedSignature = base64_encode(hash_hmac('sha256', $payload, $orderSource->api_secret, true));

        \Log::info('Webhook signature validation:', [
            'expected' => $expectedSignature,
            'received' => $signature,
            'payload' => $payload,
        ]);

        return hash_equals($expectedSignature, $signature);
    }

    protected function parseOrderData($platform, $data, $orderSource)
    {
        switch ($platform) {
            case 'Shopify':
                $customer = is_array($data['customer'] ?? null) ? $data['customer'] : [];
                return [
                    'party_id' => $data['party_id'] ?? null,
                    'invoiceNumber' => $data['id'] ?? 'INV-' . uniqid(),
                    'customer_name' => ($customer['first_name'] ?? 'Unknown') . ' ' . ($customer['last_name'] ?? 'Customer'),
                    'totalAmount' => $data['total_price'] ?? 0.0, 
                    'dueAmount' => $data['due_amount'] ?? 0.0, 
                    'paidAmount' => $data['paid_amount'] ?? $data['total_price'] ?? 0.0,
                    
                    'saleDate' => $data['sale_date'] ?? now(),
                    'delivery_type' => $data['delivery_type'] ?? 0,
                    'parcel_type' => $data['delivery_type'] ?? 0,
                    'delivery_fees' => $data['delivery_fees'] ?? 0,
                    'sale_status' => $data['sale_status'] ?? 1,
                     
                    'meta' => json_encode($data),
                ];

            default:
                throw new \Exception('Unsupported platform');
        }
    }

    public function registerWebhook(OrderSource $orderSource)
    {
        \Log::info('Registering webhook for:', ['orderSource' => $orderSource]);

        switch ($orderSource->name) {
            case 'Shopify':
                return $this->registerShopifyWebhook($orderSource);
            case 'WooCommerce':
                return $this->registerWooCommerceWebhook($orderSource);
            case 'YouCan':
                return $this->registerYouCanWebhook($orderSource);
            default:
                \Log::error('Unsupported platform for webhook registration:', ['name' => $orderSource->name]);
                return response()->json(['message' => 'Unsupported platform'], 400);
        }
    }

    protected function registerShopifyWebhook(OrderSource $orderSource)
    {
        \Log::info('Registering Shopify webhook for:', ['orderSource' => $orderSource]);

        $webhookUrl = $orderSource->webhook_url;
        $settings = is_array($orderSource->settings) ? $orderSource->settings : json_decode($orderSource->settings, true);

        if (!isset($settings['shop_domain'])) {
            \Log::error('Shopify store URL is missing in settings:', ['settings' => $settings]);
            return response()->json(['message' => 'Shopify store URL is missing in settings'], 400);
        }

        $shopifyStoreUrl = $settings['shop_domain'];

        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $orderSource->api_key,
        ])->post("https://{$shopifyStoreUrl}/admin/api/2025-04/webhooks.json", [
            'webhook' => [
                'topic' => 'orders/create',
                'address' => $webhookUrl,
                'format' => 'json',
            ],
        ]);

        // Log the full response
        \Log::info('Shopify API Response:', [
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $response->json(),
        ]);

        if ($response->successful()) {
            \Log::info('Shopify webhook registered successfully:', ['response' => $response->json()]);
            return response()->json(['message' => 'Shopify webhook registered successfully']);
        }

        \Log::error('Failed to register Shopify webhook:', ['response' => $response->body()]);
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

    public function shopifyCallback(Request $request)
    {
        $shop = $request->input('shop');
        $code = $request->input('code');

        if (!$shop || !$code) {
            return redirect()->route('business.orderSource.index')->with('error', __('Invalid OAuth response.'));
        }

        // Retrieve API key and secret from the session
        $apiKey = session('api_key');
        $apiSecret = session('api_secret');

        if (!$apiKey || !$apiSecret) {
            return redirect()->route('business.orderSource.index')->with('error', __('API key or secret is missing.'));
        }

        // Exchange the authorization code for an access token
        $response = Http::post("https://{$shop}/admin/oauth/access_token", [
            'client_id' => $apiKey,
            'client_secret' => $apiSecret,
            'code' => $code,
        ]);

        if ($response->failed()) {
            return redirect()->route('business.orderSource.index')->with('error', __('Failed to connect to Shopify.'));
        }

        $accessToken = $response->json('access_token');

        // Retrieve other temporary data from session
        $shopifyStoreUrl = session('shopify_store_url');
        $accountName = session('account_name');
        $status = session('status');

        // Save the OrderSource with the access token, API key, and API secret
        $orderSource = OrderSource::create([
            'business_id' => auth()->user()->business_id,
            'user_id' => auth()->id(),
            'account_name' => $accountName,
            'name' => 'Shopify',
            'api_key' => $apiKey,
            'api_secret' => $apiSecret,
            'webhook_url' => route('shopify.webhook'),
            'status' => $status,
            'settings' => json_encode([
                'shop_domain' => $shop,
                'access_token' => $accessToken,
            ]),
        ]);

        return redirect()->route('business.orderSource.index')->with('success', __('Shopify store connected successfully.'));
    }

    public function connectShopify(Request $request)
    {
        $shop = $request->input('shop'); // Shopify store URL (e.g., 'example.myshopify.com')

        if (!$shop) {
            return redirect()->back()->with('error', __('Shop URL is required.'));
        }

        $apiKey = config('services.shopify.api_key'); // Ensure this is the correct API Key
        $redirectUri = route('shopify.callback'); 
        $scopes = 'read_orders,write_orders,read_products';

        $oauthUrl = "https://{$shop}/admin/oauth/authorize?client_id={$apiKey}&scope={$scopes}&redirect_uri={$redirectUri}";

        return redirect()->away($oauthUrl);
    }

    public function storeShopifyOrder(Request $request)
    {
        // Decode the incoming order data
        $orderData = json_decode($request->getContent(), true);

        // Retrieve the associated OrderSource using the shop domain
        $shopDomain = $orderData['domain'] ?? null;
        $orderSource = OrderSource::where('settings->shop_domain', $shopDomain)->first();

        if (!$orderSource) {
            \Log::error('OrderSource not found for shop domain.', ['shop_domain' => $shopDomain]);
            return response()->json(['message' => 'OrderSource not found.'], 404);
        }

        // Verify the webhook signature using the SaaS user's api_secret
        $hmacHeader = $request->header('X-Shopify-Hmac-Sha256');
        $data = $request->getContent();
        $calculatedHmac = base64_encode(hash_hmac('sha256', $data, $orderSource->api_secret, true));

        if (!hash_equals($hmacHeader, $calculatedHmac)) {
            \Log::warning('Shopify webhook verification failed.', ['shop_domain' => $shopDomain]);
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Check if the order already exists in the sales table
        $existingSale = Sale::where('invoiceNumber', $orderData['id'])->first();
        if ($existingSale) {
            \Log::info('Order already exists in the sales table.', ['order_id' => $orderData['id']]);
            return response()->json(['message' => 'Order already exists.'], 200);
        }

        // Prepare the order data for storage
        $customer = $orderData['customer'] ?? [];
        $saleData = [
            'business_id' => $orderSource->business_id,
            'user_id' => $orderSource->user_id,
            'order_source_id' => $orderSource->id,
            'invoiceNumber' => $orderData['id'], // Shopify order ID
            'customer_name' => ($customer['first_name'] ?? 'Unknown') . ' ' . ($customer['last_name'] ?? 'Customer'),
            'customer_email' => $customer['email'] ?? null,
            'totalAmount' => $orderData['total_price'] ?? 0.0,
            'paidAmount' => $orderData['total_price'] ?? 0.0, // Assuming fully paid
            'dueAmount' => 0, // Assuming no due amount
            'saleDate' => $orderData['created_at'] ?? now(),
            'sale_status' => 1, // Assuming active sale
            'meta' => json_encode($orderData), // Store the full order data as JSON
        ];

        // Store the order in the sales table
        try {
            $sale = Sale::create($saleData);

            \Log::info('Shopify order stored successfully.', ['sale_id' => $sale->id]);
            return response()->json(['message' => 'Order stored successfully.', 'sale' => $sale], 200);
        } catch (\Exception $e) {
            \Log::error('Failed to store Shopify order.', ['error' => $e->getMessage(), 'order_data' => $orderData]);
            return response()->json(['message' => 'Failed to store order.'], 500);
        }
    }
}
