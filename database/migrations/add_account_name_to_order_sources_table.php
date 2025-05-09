<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountNameToOrderSourcesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('order_sources', function (Blueprint $table) {
            $table->string('account_name')->after('id')->nullable(); // Add account_name column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('order_sources', function (Blueprint $table) {
            $table->dropColumn('account_name'); // Remove account_name column
        });
    }
}