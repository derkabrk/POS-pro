<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToTicketSystemsTable extends Migration
{
    public function up()
    {
        Schema::table('ticket_systems', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('ticket_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('ticket_systems', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}