<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sent_bulk_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('user_id')->nullable(); // sender
            $table->string('type'); // email, sms, whatsapp, viber
            $table->text('recipients'); // comma separated
            $table->string('subject')->nullable();
            $table->text('content'); // message or email body
            $table->string('header_image')->nullable();
            $table->json('results')->nullable(); // status per recipient
            $table->timestamps();
            $table->index('business_id');
            $table->index('type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sent_bulk_messages');
    }
};
