<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('dropshippers', function (Blueprint $table) {
            $table->string('wilaya')->nullable();
            $table->string('store_logo')->nullable();
            $table->boolean('is_registered')->default(false);
        });
    }

    public function down()
    {
        Schema::table('dropshippers', function (Blueprint $table) {
            $table->dropColumn(['wilaya', 'store_logo', 'is_registered']);
        });
    }
};
