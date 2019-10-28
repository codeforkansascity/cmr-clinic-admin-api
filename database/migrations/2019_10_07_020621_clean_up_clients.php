<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CleanUpClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('dob_text');
            $table->dropColumn('license_expiration_date_text');
            $table->dropColumn('filing_court');
            $table->dropColumn('judicial_circuit_number');
            $table->dropColumn('judge_name');
            $table->dropColumn('division_name');
            $table->dropColumn('petitioner_name');
            $table->dropColumn('division_number');
            $table->dropColumn('city_name_here');
            $table->dropColumn('county_name');
            $table->dropColumn('arresting_county');
            $table->dropColumn('prosecuting_county');
            $table->dropColumn('arresting_municipality');
            $table->dropColumn('other_agencies_name');
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
            $table->string('dob_text', 64)->nullable();
            $table->string('license_expiration_date_text', 64)->nullable();
            $table->string('filing_court', 64)->nullable();

            $table->text('judicial_ciruit_number')->nullable();
            $table->string('count_name', 64)->nullable();
            $table->text('judge_name')->nullable();
            $table->text('division_name')->nullable();
            $table->text('petitioner_name')->nullable();
            $table->text('division_number')->nullable();
            $table->text('city_name_here')->nullable();

            $table->text('county_name')->nullable();
            $table->text('arresting_county')->nullable();
            $table->text('prosecuting_county')->nullable();
            $table->text('arresting_municipality')->nullable();
            $table->text('other_agencies_name')->nullable();
        });
    }
}
