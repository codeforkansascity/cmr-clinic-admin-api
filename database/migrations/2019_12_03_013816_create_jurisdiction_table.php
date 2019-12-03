<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurisdictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurisdictions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jurisdiction_type_id')->nullable();
            $table->string('name');
            $table->string('url')->nullable()->default('');
            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        \App\Jurisdiction::create([
            "id"=> "1",
            "name"=> "Missouri",
            "jurisdiction_type_id" => 1,
            "created_by"=> "1",
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurisdictions');
    }
}
