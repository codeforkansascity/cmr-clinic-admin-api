<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('conviction_id')->default(0);

            $table->string('charge',64)->nullable();
            $table->string('citation',64)->nullable();
            $table->string('conviction_class_type',64)->nullable();
            $table->string('conviction_charge_type',64)->nullable();
            $table->string('sentence',64)->nullable();
            $table->string('convicted',64)->nullable();
            $table->string('eligible',64)->nullable();
            $table->string('please_expunge',64)->nullable();
            $table->string('to_print',64)->nullable();

            $table->text('notes')->nullable();


            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();

            $table->timestamps();

         //   $table->foreign('conviction_id')->references('id')->on('convictions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

//        Schema::table('convictions', function(Blueprint $table) {
//            $table->dropForeign('charges_convictions_id_foreign');
//        });
        Schema::dropIfExists('charge');
    }
}
