<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportMshpChargeCodeManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_mshp_charge_code_manuals', function (Blueprint $table) {
            $table->id();
            $table->string('charge_code')->default(null)->nullable();
            $table->string('ncic_mod')->default(null)->nullable();
            $table->string('state_mod')->default(null)->nullable();
            $table->string('description')->default(null)->nullable();
            $table->string('type_class')->default(null)->nullable();
            $table->string('dna')->default(null)->nullable();
            $table->string('sor')->default(null)->nullable();
            $table->string('roc')->default(null)->nullable();
            $table->string('case_type')->default(null)->nullable();
            $table->string('effective_date')->default(null)->nullable();
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
        Schema::dropIfExists('import_mshp_charge_code_manuals');
    }
}
