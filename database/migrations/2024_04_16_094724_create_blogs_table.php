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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Creator Id
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('image');
            $table->boolean('status')->default(1);
            $table->longText('descriptions')->nullable();
            $table->text('tags')->nullable();
            $table->longText('meta')->nullable(); // Meta Title, Meta Description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
