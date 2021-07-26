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
            $table->string('charge_code');
            $table->string('ncic_mod');
            $table->string('state_mod');
            $table->text('description');
            $table->string('type_class');
            $table->string('dna');
            $table->string('sor');
            $table->string('roc');
            $table->string('case_type');
            $table->date('effective_date')->nullable();
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
