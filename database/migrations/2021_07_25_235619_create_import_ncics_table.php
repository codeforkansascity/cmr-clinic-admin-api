<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportNcicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_ncics', function (Blueprint $table) {
            $table->id();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_ncics');
    }
}
