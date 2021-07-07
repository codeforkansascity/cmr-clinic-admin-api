<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('law_id')->nullable();
            $table->string('number')->nullable();
            $table->string('name', 500);
            $table->string('common_name')->nullable();
            $table->unsignedBigInteger('jurisdiction_id')->nullable();
            $table->text('note')->nullable();
            $table->integer('statutes_eligibility_id')->default(0)->nullable();
            $table->integer('blocks_time')->default(null)->nullable();


            $table->unsignedBigInteger('same_as_id')->nullable();

            $table->unsignedBigInteger('superseded_id')->nullable();

            $table->string('superseded_on')->default('')->nullable();

            $table->timestamps();
            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();
            $table->softDeletes();

            $table->index(['statutes_eligibility_id']);

            $table->foreign('jurisdiction_id')
                ->references('id')->on('jurisdictions')->onDelete('set null');

            $table->foreign('same_as_id')
                ->references('id')->on('statutes')->onDelete('set null');

            $table->foreign('superseded_id')->references('id')
                ->on('statutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('law_versions');
    }
}
