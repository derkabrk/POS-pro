<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('tracking_id')->unique();
            if (!Schema::hasColumn('sales', 'sale_status')) {
                $table->integer('sale_status')->default(1)->after('sale_type'); 
            } else {
                $table->integer('sale_status')->default(1)->change(); 
            }
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'sale_status')) {
                $table->dropColumn('sale_status');
            }
        });
    }
};