<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('business_id');
            }
            if (!Schema::hasColumn('users', 'plan_permissions')) {
                $table->json('plan_permissions')->nullable()->after('plan_id');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'plan_id')) {
                $table->dropColumn('plan_id');
            }
            if (Schema::hasColumn('users', 'plan_permissions')) {
                $table->dropColumn('plan_permissions');
            }
        });
    }
};
