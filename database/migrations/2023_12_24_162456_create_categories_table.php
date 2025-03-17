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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('categoryName');
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->boolean('variationCapacity')->default(0);
            $table->boolean('variationColor')->default(0);
            $table->boolean('variationSize')->default(0);
            $table->boolean('variationType')->default(0);
            $table->boolean('variationWeight')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
