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
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
            $table->string("paymentType")->nullable()->change();
        });
        Schema::table('due_collects', function (Blueprint $table) {
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
            $table->string("paymentType")->nullable()->change();
        });
        Schema::table('incomes', function (Blueprint $table) {
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
            $table->string("paymentType")->nullable()->change();
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('payment_type_id')->nullable()->after('paymentType');
            $table->string("paymentType")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('payment_type_id');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('payment_type_id');
            $table->string("paymentType")->default("Cash")->change();
        });
        Schema::table('due_collects', function (Blueprint $table) {
            $table->dropColumn('payment_type_id');
            $table->string("paymentType")->default("Cash")->change();
        });
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('payment_type_id');
            $table->string("paymentType")->default("Cash")->change();
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('payment_type_id');
            $table->string("paymentType")->default("Cash")->change();
        });
    }
};
