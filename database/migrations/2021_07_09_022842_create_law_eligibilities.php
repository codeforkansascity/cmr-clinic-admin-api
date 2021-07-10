<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawEligibilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_eligibilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 60)->unique();
            $table->integer('sequence')->default(0)->nullable();
            $table->timestamps();
            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->softDeletes();
        });

        $status = \App\Models\LawEligibility::create([
            'id' => \App\Models\Law::ELIGIBLE,
            'name' => 'Eligible',
            'sequence' => 10,
        ]);
        $status = \App\Models\LawEligibility::create([
            'id' => \App\Models\Law::INELIGIBLE,
            'name' => 'Ineligible',
            'sequence' => 20,
        ]);
        $status = \App\Models\LawEligibility::create([
            'id' => \App\Models\Law::POSSIBLY,
            'name' => 'Possibly Eligable',
            'sequence' => 30,
        ]);
        $status = \App\Models\LawEligibility::create([
            'id' => \App\Models\Law::UNDETERMINED,
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
        Schema::dropIfExists('law_eligibilities');
    }
}
