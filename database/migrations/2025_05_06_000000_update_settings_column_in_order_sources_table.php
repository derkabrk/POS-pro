<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSettingsColumnInOrderSourcesTable extends Migration
{
    public function up()
    {
        Schema::table('order_sources', function (Blueprint $table) {
            $table->string('settings')->nullable()->change(); // Change settings to a string
        });
    }

    public function down()
    {
        Schema::table('order_sources', function (Blueprint $table) {
            $table->json('settings')->nullable()->change(); // Revert back to JSON if needed
        });
    }
}