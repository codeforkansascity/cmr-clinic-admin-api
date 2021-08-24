<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportMoRevisorStatutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_mo_revisor_statutes', function (Blueprint $table) {
            $table->id();
            $table->integer('cmr_chapter')->default(null)->nullable();
            $table->string('cmr_law_number')->default(null)->nullable();
            $table->longText('cmr_law_title')->default(null)->nullable();

            $table->string('title')->default(null)->nullable();
            $table->string('chapter_name')->default(null)->nullable();
            $table->string('rsmo_section')->default(null)->nullable();
            $table->longText('section_title')->default(null)->nullable();
            $table->date('amended_date')->nullable();
            $table->string('expungable')->default(null)->nullable();
            $table->string('source_law')->default(null)->nullable();
            $table->string('source_description')->default(null)->nullable();

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
        Schema::dropIfExists('import_mo_revisor_statutes');
    }
}
