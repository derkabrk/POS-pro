<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketSystemsTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_systems', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('status'); // e.g., Open, Closed, Pending
            $table->string('priority'); // e.g., Low, Medium, High
            $table->foreignId('category_id')->nullable()->constrained('ticket_categories')->onDelete('set null');
            $table->unsignedBigInteger('assigned_to')->nullable(); // User ID of the assigned person
            $table->unsignedBigInteger('created_by')->nullable(); // User ID of the creator
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_systems');
    }
}