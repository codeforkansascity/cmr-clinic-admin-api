<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_sources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('url')->nullable()->default('');
            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        \App\DataSource::create([
            "id"=> "1",
            "name"=> "Lexis",
            "created_by"=> "1",
        ]);

        \App\DataSource::create([
            "id"=> "2",
            "name"=> "CaseNet",
            "created_by"=> "1",
        ]);

        \App\DataSource::create([
            "id"=> "3",
            "name"=> "MSHP",
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
        Schema::dropIfExists('data_sources');
    }
}
