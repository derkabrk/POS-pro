<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dropshippers', function (Blueprint $table) {
            $table->id();
            $table->string('store');
            $table->string('phone')->nullable();
            $table->string('full_name');
            $table->integer('total_orders')->default(0);
            $table->integer('delivered')->default(0);
            $table->integer('returned')->default(0);
            $table->integer('pending')->default(0);
            $table->decimal('available', 12, 2)->default(0);
            $table->decimal('paid', 12, 2)->default(0);
            $table->decimal('cashout', 12, 2)->default(0);
            $table->date('expires')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dropshippers');
    }
};
