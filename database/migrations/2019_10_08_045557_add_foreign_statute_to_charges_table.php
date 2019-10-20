<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignStatuteToChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->string('charge', 400)->nullable()->change();
            $table->renameColumn('charge', 'imported_statute');
            $table->renameColumn('citation', 'imported_citation');

            $table->foreign('statute_id')
                ->references('id')->on('statutes')->onDelete('set null');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->string('charge',64)->nullable();
            $table->renameColumn('imported_statute', 'charge');
            $table->renameColumn('imported_citation', 'citation');
            $table->dropForeign(['statute_id']);
        });
    }
}
