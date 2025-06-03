<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('dropshippers', function (Blueprint $table) {
            $table->string('full_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
        });
    }

    public function down()
    {
        Schema::table('dropshippers', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'email', 'password', 'phone']);
        });
    }
};
