<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {



            $table->integer('created_by')->default(0)->nullable()->after('created_at');
            $table->integer('modified_by')->default(0)->nullable()->after('created_by');
            $table->integer('purged_by')->default(0)->nullable()->after('modified_by');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('modified_by');
            $table->dropColumn('purged_by');

            $table->dropSoftDeletes();

        });
    }
}
