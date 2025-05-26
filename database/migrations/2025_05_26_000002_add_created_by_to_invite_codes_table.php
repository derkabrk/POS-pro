<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('invite_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('expires_at');
        });
    }

    public function down()
    {
        Schema::table('invite_codes', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
};
