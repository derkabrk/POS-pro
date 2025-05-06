<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_api_headers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the API header
            $table->string('api_key'); // API key or Pixel ID
            $table->boolean('status')->default(true); // Active or Inactive
            $table->text('description')->nullable(); // Optional description
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_api_headers');
    }
};