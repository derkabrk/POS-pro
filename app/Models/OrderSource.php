<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class OrderSource extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_name', // Account name for the order source
        'name', // e.g., Shopify, YouCan, WooCommerce
        'api_key', // API key for the platform
        'api_secret', // API secret for the platform
        'webhook_url', // Webhook URL for receiving updates
        'status', // Active or inactive
        'settings', // Store URL as a plain string
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'settings' => 'string', // Treat settings as a plain string
    ];

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically create a webhook when an OrderSource is created
       /* static::created(function ($orderSource) {
            $orderSource->createPlatformWebhook();
        });

        // Automatically update the webhook when an OrderSource is updated
        static::updated(function ($orderSource) {
            $orderSource->createPlatformWebhook();
        });*/
    }

    /**
     * Create a webhook on the platform.
     */
    public function createPlatformWebhook()
    {
        if (!$this->webhook_url) {
            return;
        }

        switch ($this->name) {
            case 'Shopify':
                $this->createShopifyWebhook();
                break;
            case 'YouCan':
                $this->createYouCanWebhook();
                break;
            case 'WooCommerce':
                $this->createWooCommerceWebhook();
                break;
            default:
                // Unsupported platform
                break;
        }
    }

    /**
     * Create a webhook for Shopify.
     */
    protected function createShopifyWebhook()
    {
        $settings = $this->settings;

        if (!isset($settings['shop_domain'])) {
            \Log::error('Shopify settings are missing the shop_domain key.');
            return;
        }

        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->api_key,
        ])->post("https://{$settings['shop_domain']}/admin/api/2023-01/webhooks.json", [
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

    /**
     * Create a webhook for YouCan.
     */
    protected function createYouCanWebhook()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_key,
        ])->post("https://api.youcan.shop/v1/webhooks", [
            'url' => $this->webhook_url,
            'event' => 'order.created',
        ]);

        if ($response->failed()) {
            \Log::error('Failed to create YouCan webhook: ' . $response->body());
        }
    }

    /**
     * Create a webhook for WooCommerce.
     */
    protected function createWooCommerceWebhook()
    {
        $settings = $this->settings;

        if (!isset($settings['store_url'])) {
            \Log::error('WooCommerce settings are missing the store_url key.');
            return;
        }

        $response = Http::withBasicAuth($this->api_key, $this->api_secret)
            ->post("{$settings['store_url']}/wp-json/wc/v3/webhooks", [
                'name' => 'Order Created Webhook',
                'topic' => 'order.created',
                'delivery_url' => $this->webhook_url,
                'status' => 'active',
            ]);

        if ($response->failed()) {
            \Log::error('Failed to create WooCommerce webhook: ' . $response->body());
        }
    }

    /**
     * Get the settings attribute.
     * Decode the settings JSON into an array.
     */
    public function getSettingsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }
}