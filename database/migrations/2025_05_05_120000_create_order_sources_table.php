<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Platform name (e.g., Shopify, WooCommerce)
            $table->string('api_key'); // API key for integration
            $table->string('api_secret'); // API secret for integration
            $table->string('webhook_url')->nullable(); // Webhook URL for updates
            $table->boolean('status')->default(true); // Active or inactive
            $table->json('settings')->nullable(); // Additional settings in JSON format
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_sources');
    }
};