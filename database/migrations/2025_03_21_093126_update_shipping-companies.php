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
            $table->string('first_r_credential_lable');
            $table->string('second_r_credential_lable');
        });
    }


    public function down(): void
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            $table->dropColumn('first_r_credential_lable');
            $table->dropColumn('second_r_credential_lable');
        });
        
    }
};
