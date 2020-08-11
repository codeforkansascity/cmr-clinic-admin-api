<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCaseSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conviction_source', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('conviction_id');
            $table->foreign('conviction_id')->references('id')->on('convictions');

            $table->unsignedBigInteger('data_source_id');
            $table->foreign('data_source_id')->references('id')->on('data_sources');

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
        //
    }
}
