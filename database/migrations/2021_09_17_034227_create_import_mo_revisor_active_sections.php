<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportMoRevisorActiveSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_mo_revisor_active_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('jurisdiction_id');
            $table->string('number');
            $table->text('description');
            $table->date('law_date')->nullable();
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
        Schema::dropIfExists('import_mo_revisor_active_sections');
    }
}
