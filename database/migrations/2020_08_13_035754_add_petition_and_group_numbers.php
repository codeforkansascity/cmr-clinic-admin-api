<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPetitionAndGroupNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::table('charges', function (Blueprint $table) {
                $table->integer('group_sequence')->default(0)->nullable()->after('please_expunge');
                $table->integer('group_number')->default(0)->nullable()->after('please_expunge');
                $table->integer('petition_number')->default(0)->nullable()->after('please_expunge');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->dropColumn('petition_number');
            $table->dropColumn('group_number');
            $table->dropColumn('group_sequence');
        });
    }
}
