<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CleanUpConvictions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('convictions', function (Blueprint $table) {
//            $table->dropColumn('release_date_text');
            $table->string('arresting_agency', 64)->nullable()->after('record_name');
            $table->string('date_of_disposition', 64)->nullable()->after('record_name');

            $table->boolean('sis')->nullable()->after('release_date_text');
            $table->string('source', 64)->nullable()->after('sis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('convictions', function (Blueprint $table) {
//            $table->string('release_date_text', 64)->nullable();
            $table->dropColumn('arresting_agency');
            $table->dropColumn('date_of_disposition');
            $table->dropColumn('source');
            $table->dropColumn('sis');
        });
    }
}
