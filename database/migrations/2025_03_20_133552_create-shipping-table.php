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
        Schema::create('shipping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_company_id')->constrained()->cascadeOnDelete();
            $table->string ("name");
            $table->string ("shipping_company");
            $table->string ("first_r_credential");
            $table->string ("second_r_credential");
            $table->json("shops");
            $table->boolean ("is_active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping');
    }
};
