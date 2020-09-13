<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetitionFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petition_fields', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('applicant_id');
            $table->unsignedBigInteger('petition_number');
            $table->string('field_name')->nullable();
            $table->string('value')->nullable();

            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();
            $table->timestamps();

//            $table->string('case_heading')->nullable();
//            $table->string('case_no')->nullable();
//            $table->string('counsel_or_pro_se_statment')->nullable();
//            $table->string('signature_block_heading')->nullable();
//            $table->string('signature_block_name')->nullable();
//            $table->string('signature_block_bar_number_or_pro_se')->nullable();
//            $table->string('signature_block_address')->nullable();
//            $table->string('signature_block_city_state_zip')->nullable();
//            $table->string('signature_block_phone')->nullable();
//            $table->string('signature_block_email')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        chema::dropIfExists('petition_fields');
    }
}
