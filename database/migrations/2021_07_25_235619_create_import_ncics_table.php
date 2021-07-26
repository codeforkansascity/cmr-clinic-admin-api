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
            $table->string('ncic_category');
            $table->string('ncic_modifier');
            $table->string('category_description');
            $table->string('modifier_description');
            $table->string('caution');
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
