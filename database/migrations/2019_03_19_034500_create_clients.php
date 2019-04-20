<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('full_name',64)->default('');
            $table->string('phone',64)->nullable();
            $table->string('email',225)->nullable();
            $table->string('sex',64)->nullable();
            $table->string('race',64)->nullable();
            $table->string('dob',64)->nullable();
            $table->string('address_line_1',64)->nullable();
            $table->string('address_line_2',64)->nullable();
            $table->string('city',64)->nullable();
            $table->string('state',64)->nullable();
            $table->string('zip',64)->nullable();
            $table->string('license_number',64)->nullable();
            $table->string('license_issuing_state',64)->nullable();
            $table->string('license_expiration_date',64)->nullable();

            // NEW
            $table->string('filing_court',64)->nullable();

            $table->string('judicial_ciruit_number',64)->nullable();
            $table->string('count_name',64)->nullable();
            $table->string('judge_name',64)->nullable();
            $table->string('division_name',64)->nullable();
            $table->string('petitioner_name',64)->nullable();
            $table->string('division_number',64)->nullable();
            $table->string('city_name_here',64)->nullable();
            $table->string('county_name',64)->nullable();
            $table->string('arresting_county',64)->nullable();
            $table->string('prosecuting_county',64)->nullable();
            $table->string('arresting_municipality',64)->nullable();
            $table->text('other_agencies_name')->nullable();
            //

            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();

            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
