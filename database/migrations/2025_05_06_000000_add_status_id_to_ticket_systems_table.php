<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusIdToTicketSystemsTable extends Migration
{
    public function up()
    {
        Schema::table('ticket_systems', function (Blueprint $table) {
            $table->foreignId('status_id')->nullable()->constrained('ticket_statuses')->onDelete('set null');
            $table->unsignedBigInteger('business_id')->nullable()->after('category_id'); // Add the business_id column
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('ticket_systems', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
           $table->dropForeign(['business_id']); // Drop foreign key
           $table->dropColumn('business_id');
        });
    }
}