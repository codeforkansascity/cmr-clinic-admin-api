<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportChargeCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_charge_codes', function (Blueprint $table) {
            $table->id();

            $table->string('charge_type',99)->default(null)->nullable();
            $table->string('classification',99)->default(null)->nullable();
            $table->string('effective_date',99)->default(null)->nullable();
            $table->string('inactive_date',99)->default(null)->nullable();
            $table->string('reportable',99)->default(null)->nullable();
            $table->string('short_description',99)->default(null)->nullable();
            $table->string('not_applicable',99)->default(null)->nullable();
            $table->string('attempt',99)->default(null)->nullable();
            $table->string('accessory',99)->default(null)->nullable();
            $table->string('coonspiracy',99)->default(null)->nullable();
            $table->string('code_category',99)->default(null)->nullable();
            $table->string('ncic_category',99)->default(null)->nullable();
            $table->string('statute',99)->default(null)->nullable();
            $table->string('long_description',99)->default(null)->nullable();
            $table->string('uniform_citation_ind',99)->default(null)->nullable();
            $table->string('rec_of_conviction',99)->default(null)->nullable();
            $table->string('case_type',99)->default(null)->nullable();
            $table->string('charge_code',99)->default(null)->nullable();
            $table->string('dna_at_arrest',99)->default(null)->nullable();

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
        Schema::dropIfExists('import_charge_codes');
    }
}
