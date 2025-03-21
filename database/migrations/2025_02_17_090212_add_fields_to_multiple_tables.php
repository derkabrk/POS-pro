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
        Schema::table('products', function (Blueprint $table) {
            $table->double('alert_qty')->default(0)->after('productStock');
            $table->date('expire_date')->nullable()->after('productStock');
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->string('discount_type')->default('flat')->after('discountAmount'); // flat, percent
            $table->double('discount_percent')->default(0)->after('discountAmount');
            $table->double('shipping_charge')->default(0)->after('discountAmount');
            $table->string('image')->nullable()->after('saleDate');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('discount_type')->default('flat')->after('discountAmount'); // flat, percent
            $table->double('discount_percent')->default(0)->after('discountAmount');
            $table->double('shipping_charge')->default(0)->after('discountAmount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['alert_qty', 'expire_date']);
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'shipping_charge', 'image']);
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'shipping_charge', 'image']);
        });

    }
};
