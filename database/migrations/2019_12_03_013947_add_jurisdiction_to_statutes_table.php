<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJurisdictionToStatutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statutes', function (Blueprint $table) {
            $table->unsignedBigInteger('jurisdiction_id')->nullable();
            $table->foreign('jurisdiction_id')
                ->references('id')->on('jurisdictions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statues', function (Blueprint $table) {
            $table->dropForeign('jurisdiction_id');
        });
    }
}
