<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('dropshippers', function (Blueprint $table) {
            $table->unsignedBigInteger('business_id')->nullable()->after('id');
            $table->unsignedBigInteger('user_id')->nullable()->after('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('dropshippers', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['business_id', 'user_id']);
        });
    }
};
