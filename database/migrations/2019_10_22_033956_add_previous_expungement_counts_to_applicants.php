<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviousExpungementCountsToApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->integer('previous_misdemeanor_expungements')->default(0)->nullable()->after('previous_expungements');
            $table->integer('previous_felony_expungements')->default(0)->nullable()->after('previous_expungements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('previous_felony_expungements');
            $table->dropColumn('previous_misdemeanor_expungements');
        });
    }
}
