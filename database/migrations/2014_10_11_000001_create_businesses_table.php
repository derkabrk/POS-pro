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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_subscribe_id')->nullable();
            $table->foreignId('business_category_id')->constrained()->cascadeOnDelete();
            $table->string('companyName');
            $table->date('will_expire')->nullable();
            $table->string('address')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('pictureUrl')->nullable();
            $table->timestamp('subscriptionDate')->nullable();
            $table->double('remainingShopBalance', 10, 2)->default(0);
            $table->double('shopOpeningBalance', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
