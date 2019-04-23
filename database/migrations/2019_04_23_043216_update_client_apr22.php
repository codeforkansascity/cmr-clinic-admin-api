<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClientApr22 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->renameColumn('judicial_ciruit_number', 'judicial_circuit_number');
            $table->text('previous_expungements')->nullable();
            $table->renameColumn('zip', 'zip_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->renameColumn('judicial_circuit_number', 'judicial_ciruit_number');
            $table->dropColumn('previous_expungements');
            $table->renameColumn('zip_code', 'zip');

        });
    }
}
