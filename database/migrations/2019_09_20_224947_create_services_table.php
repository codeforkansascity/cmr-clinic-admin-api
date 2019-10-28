<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('attn')->nullable();
            $table->string('address')->nullable();
            $table->string('address_line_2',64)->nullable();
            $table->string('city',64)->nullable();
            $table->string('state',64)->nullable();
            $table->string('zip',64)->nullable();
            $table->string('county',64)->nullable();

            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('note', 600)->nullable();

            $table->unsignedBigInteger('service_type_id')->nullable();
            $table->foreign('service_type_id')->references('id')
                ->on('service_types');

            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        \App\Service::create([
            "id"=> "1",
            "name"=> "16th Circuit Court of Jackson County, Missouri OR 16th Circuit Court",
            "attn" => "Court Clerk",
            "address"=> "415 E 12th St Suite 300",
            "address_line_2"=> "NULL",
            "city"=> "Kansas City",
            "state"=> "MO",
            "zip"=> "64106",
            "county"=> "Jackson",
            "phone"=> "(816) 881-3934",
            "service_type_id"=> "2",
            "created_by"=> "1",
        ]);

        \App\Service::create([
            "id"=> "2",
            "name"=> "Clinton County Circuit Court",
            "attn" => "Court Clerk",
            "address"=> "207 N Main St",
            "address_line_2"=> "NULL",
            "city"=> "Plattsburg",
            "state"=> "MO",
            "zip"=> "64477",
            "county"=> "Clinton",
            "phone"=> "NULL",
            "email"=> "NULL",
            "note"=> "NULL",
            "service_type_id"=> "2",
        ]);


        \App\Service::create([
            "id"=> "3",
            "name"=> "11th Judicial Circuit Court St. Charles County",
            "attn" => "Court Clerk",
            "address"=> "300 North 2nd Street",
            "address_line_2"=> "NULL",
            "city"=> "St Charles",
            "state"=> "MO",
            "zip"=> "63301",
            "county"=> "NULL",
            "phone"=> "636-949-3080",
            "email"=> "NULL",
            "note"=> "NULL",
            "service_type_id"=> "2",
        ]);


        \App\Service::create([
            "id"=> "6",
            "name"=> "7th Judicial Circuit - Clay County Courthouse",
            "attn" => "Court Clerk",
            "address"=> "11 South Water",
            "address_line_2"=> "NULL",
            "city"=> "Liberty",
            "state"=> "MO",
            "zip"=> "64068",
            "county"=> "Clay",
            "phone"=> "(816) 407-3900",
            "email"=> "NULL",
            "note"=> "<p>Garrett Lee Bucksath, Circuit Clerk</p><p>&nbsp;</p>",
            "service_type_id"=> "2",
        ]);

        \App\Service::create([
            "id"=> "7",
            "name"=> "South Platte County-Platte City",
            "attn" => "Clerk",
            "service_type_id"=> "1",
        ]);

        \App\Service::create([
            "id"=> "8",
            "name"=> "Raymore PD",
            "attn" => "Clerk",
            "service_type_id"=> "1",
        ]);


//        \App\Service::create([
//
//        ]);



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
