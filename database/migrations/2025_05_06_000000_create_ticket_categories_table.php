<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_categories');
    }
}