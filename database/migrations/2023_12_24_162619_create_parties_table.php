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
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->string('email')->nullable();
            $table->string('type')->default('Retailer'); // Retailer || Dealer || Wholesaler || Supplier
            $table->string('phone')->unique()->nullable();
            $table->double('due', 10, 2)->default(0);
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
