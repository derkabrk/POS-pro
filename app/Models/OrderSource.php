<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSource extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', // e.g., Shopify, YouCan, WooCommerce
        'api_key', // API key for the platform
        'api_secret', // API secret for the platform
        'webhook_url', // Webhook URL for receiving updates
        'status', // Active or inactive
        'settings', // Additional settings in JSON format
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'settings' => 'json',
        'status' => 'boolean',
    ];
}