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
            $table->integer('display_sequence')->default(0)->nullable();

            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        \App\JurisdictionType::create([
            "id"=> "1",
            "name"=> "State",
            'display_sequence' => 1,
            "created_by"=> "1",
        ]);

        \App\JurisdictionType::create([
            "id"=> "2",
            "name"=> "County",
            'display_sequence' => 2,
            "created_by"=> "1",
        ]);

        \App\JurisdictionType::create([
            "id"=> "3",
            "name"=> "Municipal",
            'display_sequence' => 3,
            "created_by"=> "1",
        ]);

        \App\JurisdictionType::create([
            "id"=> "4",
            "name"=> "Unknown",
            'display_sequence' => 4,
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
