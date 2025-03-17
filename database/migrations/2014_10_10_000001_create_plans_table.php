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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('subscriptionName');
            $table->integer('duration')->default(0); // Duration in days
            $table->double('offerPrice', 10, 2)->nullable();
            $table->double('subscriptionPrice', 10, 2)->default(0);
            $table->boolean('status')->default(1);
            $table->longText('features')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
