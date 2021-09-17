<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportMshpNcicModifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_mshp_ncic_modifiers', function (Blueprint $table) {
            $table->id();
            $table->integer('mshp_version_id');
            $table->string('cmr_law_number')->default(null)->nullable();
            $table->string('cmr_chapter')->default(null)->nullable();
            $table->string('cmr_charge_code_seq')->default(null)->nullable();
            $table->string('cmr_charge_code_fingerprintable')->default(null)->nullable();
            $table->string('cmr_charge_code_effective_year')->default(null)->nullable();
            $table->string('cmr_charge_code_ncic_category')->default(null)->nullable();
            $table->string('cmr_charge_code_ncic_modifier')->default(null)->nullable();

            $table->string('ncic_category');
            $table->string('ncic_range');
            $table->string('misc');
            $table->string('charge_code');
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
        Schema::dropIfExists('import_mshp_ncic_modifiers');
    }
}
