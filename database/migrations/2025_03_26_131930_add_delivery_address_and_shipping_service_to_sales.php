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
        Schema::table('sales', function (Blueprint $table) {
            $table->text('delivery_address')->nullable()->after('sale_status'); // Adding delivery_address
            $table->foreignId('shipping_service_id')->nullable()->constrained('shippings')->nullOnDelete()->after('delivery_address');
            $table->json('products')->nullable(); // Foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('delivery_address');
            $table->dropForeign(['shipping_service_id']);
            $table->dropColumn('shipping_service_id');
             $table->dropColumn('products');
        });
    }
};
