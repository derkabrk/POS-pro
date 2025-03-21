<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->double('productStock', 10, 2)->default(0)->change();
        });

        Schema::table('sale_details', function (Blueprint $table) {
            $table->double('quantities', 10, 2)->default(0)->change();
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->double('quantities', 10, 2)->default(0)->change();
        });

        Schema::table('purchase_return_details', function (Blueprint $table) {
            $table->double('return_qty', 10, 2)->default(0)->change();
        });

        Schema::table('sale_return_details', function (Blueprint $table) {
            $table->double('return_qty', 10, 2)->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('productStock')->default(0)->change();
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->integer('quantities')->default(0)->change();
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->integer('quantities')->default(0)->change();
        });

        Schema::table('purchase_return_details', function (Blueprint $table) {
            $table->integer('return_qty')->default(0)->change();
        });

        Schema::table('sale_return_details', function (Blueprint $table) {
            $table->integer('return_qty')->default(0)->change();
        });
    }
};
