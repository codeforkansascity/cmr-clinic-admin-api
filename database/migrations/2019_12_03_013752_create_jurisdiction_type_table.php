<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurisdictionTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurisdiction_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        \App\JurisdictionType::create([
            "id"=> "1",
            "name"=> "State",
            "created_by"=> "1",
        ]);

        \App\JurisdictionType::create([
            "id"=> "2",
            "name"=> "County",
            "created_by"=> "1",
        ]);

        \App\JurisdictionType::create([
            "id"=> "3",
            "name"=> "Municiple",
            "created_by"=> "1",
        ]);

        \App\JurisdictionType::create([
            "id"=> "4",
            "name"=> "Unknown",
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
        Schema::dropIfExists('jurisdiction_types');
    }
}
