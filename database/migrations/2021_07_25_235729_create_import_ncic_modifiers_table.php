<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportNcicModifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_ncic_modifiers', function (Blueprint $table) {
            $table->id();
            $table->string('cmr_law_number')->default(null)->nullable();
            $table->string('cmr_chapter')->default(null)->nullable();
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
        Schema::dropIfExists('import_ncic_modifiers');
    }
}
