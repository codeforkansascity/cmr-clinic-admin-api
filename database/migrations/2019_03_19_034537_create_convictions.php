<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvictions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conviction', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('client_id')->default(0);
            $table->string('name',64)->nullable();
            $table->string('arrest_date',64)->nullable();

            $table->string('case_number',64)->nullable();
            $table->string('agency',64)->nullable();
            $table->string('court_name',64)->nullable();
            $table->string('court_city_county',64)->nullable();
            $table->string('judge',64)->nullable();
            $table->string('record_name',64)->nullable();
            $table->string('release_status',64)->nullable();

            $table->date('release_date')->nullable();
            $table->text('notes')->nullable();

            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();

            $table->timestamps();

         //   $table->foreign('client_id')->references('id')->on('clients');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('conviction');
    }
}
