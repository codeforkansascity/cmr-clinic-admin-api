<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawVersionExceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_version_exceptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('law_version_id');
            $table->bigInteger('exception_id');
            $table->text('note')->nullable();

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
        Schema::dropIfExists('law_version_exceptions');
    }

}
