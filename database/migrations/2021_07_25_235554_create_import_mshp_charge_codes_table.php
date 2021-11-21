<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportMshpChargeCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_mshp_charge_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('mshp_version_id');
            $table->string('cmr_law_number')->default(null)->nullable();
            $table->string('cmr_chapter')->default(null)->nullable();
            $table->string('legacy_charge_code')->default(null)->nullable();  // Added in 2021
            $table->string('charge_type');
            $table->string('classification');
            $table->date('effective_date')->nullable();
            $table->date('inactive_date')->nullable();
            $table->string('reportable');
            $table->string('short_description');
            $table->string('not_applicable');
            $table->string('attempt');
            $table->string('accessory');
            $table->string('conspiracy');
            $table->string('code_category');
            $table->string('ncic_category');
            $table->string('statute');
            $table->text('long_description');
            $table->string('uniform_citation_ind');
            $table->string('rec_of_conviction');
            $table->string('case_type');
            $table->string('charge_code');
            $table->string('dna_at_arrest');
            $table->timestamps();

            $table->index('cmr_law_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_mshp_charge_codes');
    }
}