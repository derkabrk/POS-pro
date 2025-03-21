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
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete();
            $table->string('mode'); // 1 = Sandbox || 0 = Live
            $table->string('status');
            $table->boolean('charge')->default(0);
            $table->string('image')->nullable();
            $table->text('data')->nullable();
            $table->text('manual_data')->nullable();
            $table->boolean('is_manual')->default(0);
            $table->boolean('accept_img')->default(0);
            $table->string('namespace')->nullable();
            $table->integer('phone_required')->default(0);
            $table->text('instructions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateways');
    }
};
