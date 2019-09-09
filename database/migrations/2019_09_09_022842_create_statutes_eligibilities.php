<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatutesEligibilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statutes_eligibilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 60)->unique();
            $table->integer('sequence')->default(0)->nullable();
            $table->timestamps();
            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->softDeletes();
        });

        Schema::table('statutes', function (Blueprint $table) {
            $table->integer('statutes_eligibility_id')->default(0)->nullable();
        });

        $status = \App\StatutesEligibility::create([
            'id' => 1,
            'name' => 'Eligable',
            'sequence' => 10,
        ]);
        $status = \App\StatutesEligibility::create([
            'id' => 2,
            'name' => 'Ineligable',
            'sequence' => 20,
        ]);
        $status = \App\StatutesEligibility::create([
            'id' => 3,
            'name' => 'Possibly Eligable',
            'sequence' => 30,
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statutes_eligibilities');
    }
}
