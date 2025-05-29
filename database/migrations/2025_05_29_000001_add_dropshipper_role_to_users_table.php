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
        Schema::table('users', function (Blueprint $table) {
            // If you want to use ENUM, you can update the role column type. Otherwise, just document the new type.
            // $table->enum('role', ['admin', 'shop-owner', 'staff', 'dropshipper'])->default('shop-owner')->change();
            // If using string, no schema change is needed, but you can add a comment for clarity.
            $table->string('role')->default('shop-owner')->comment('admin, shop-owner, staff, dropshipper')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('shop-owner')->comment('admin, shop-owner, staff')->change();
        });
    }
};
