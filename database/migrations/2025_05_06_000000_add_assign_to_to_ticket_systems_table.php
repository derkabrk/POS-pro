<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
{
    Schema::table('ticket_systems', function (Blueprint $table) {
        $table->unsignedBigInteger('assign_to')->nullable()->after('business_id');
        $table->foreign('assign_to')->references('id')->on('users')->onDelete('set null');
    });
}
}