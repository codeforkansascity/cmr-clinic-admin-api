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
            $table->renameColumn('charge', 'imported_statute_name');
            $table->renameColumn('citation', 'imported_statute_number');

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
            $table->string('citation',64)->nullable();
            $table->dropForeign(['statute_id']);
        });
    }
}
