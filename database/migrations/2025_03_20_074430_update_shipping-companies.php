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
        Schema::table('shipping_companies', function (Blueprint $table) {

            $table->string('create_api_url');
            $table->string('update_api_url');
            $table->string('delete_api_url');
            $table->string('list_api_url');
            $table->string('track_api_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_companies', function (Blueprint $table) {

            $table->dropColumn('create_api_url');
            $table->dropColumn('update_api_url');
            $table->dropColumn('delete_api_url');
            $table->dropColumn('list_api_url');
            $table->dropColumn('track_api_url');
        });
    }
};
