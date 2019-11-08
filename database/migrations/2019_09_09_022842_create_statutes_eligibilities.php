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

        $status = \App\StatutesEligibility::create([
            'id' => \App\Statute::ELIGIBLE,
            'name' => 'Eligible',
            'sequence' => 10,
        ]);
        $status = \App\StatutesEligibility::create([
            'id' => \App\Statute::INELIGIBLE,
            'name' => 'Ineligible',
            'sequence' => 20,
        ]);
        $status = \App\StatutesEligibility::create([
            'id' => \App\Statute::POSSIBLY,
            'name' => 'Possibly Eligable',
            'sequence' => 30,
        ]);
        $status = \App\StatutesEligibility::create([
            'id' => \App\Statute::UNDETERMINED,
            'name' => 'Undetermined Eligibility',
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
