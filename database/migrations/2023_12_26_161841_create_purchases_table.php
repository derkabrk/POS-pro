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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id')->constrained()->cascadeOnDelete();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->double("discountAmount", 10, 2)->default(0);
            $table->double("dueAmount", 10, 2)->default(0);
            $table->double("paidAmount", 10, 2)->default(0);
            $table->double("totalAmount", 10, 2)->default(0);
            $table->string("invoiceNumber")->nullable();
            $table->boolean("isPaid")->default(0);
            $table->string("paymentType")->default("Cash");
            $table->timestamp("purchaseDate")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
