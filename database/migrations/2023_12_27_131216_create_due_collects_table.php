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
        Schema::create('due_collects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('party_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sale_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('invoiceNumber')->nullable();
            $table->double('totalDue', 10, 2)->default(0);
            $table->double('dueAmountAfterPay', 10, 2)->default(0);
            $table->double('payDueAmount', 10, 2)->default(0);
            $table->string('paymentType')->default('Cash');
            $table->timestamp('paymentDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('due_collects');
    }
};
