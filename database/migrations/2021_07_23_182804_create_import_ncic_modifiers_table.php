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

            $table->string('ncic_category',99)->default(null)->nullable();
            $table->string('ncic_range',99)->default(null)->nullable();
            $table->string('misc',99)->default(null)->nullable();
            $table->string('charge_code',99)->default(null)->nullable();

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
        Schema::dropIfExists('import_ncic_modifiers');
    }
}
