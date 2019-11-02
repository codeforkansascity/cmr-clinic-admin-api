<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statutes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('name', 500);
            $table->text('note')->nullable();
            $table->integer('statutes_eligibility_id')->default(0)->nullable();
            $table->index(['statutes_eligibility_id']);

            $table->unsignedBigInteger('superseded_id')->nullable();
            $table->foreign('superseded_id')->references('id')
                ->on('statutes');
            $table->string('superseded_on')->default('')->nullable();

            $table->timestamps();
            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();
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
        Schema::dropIfExists('statutes');
    }
}
