<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApproximateDateOfCharge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conviction', function (Blueprint $table) {
            $table->text('approximate_date_of_charge')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conviction', function (Blueprint $table) {
            $table->dropColumn('approximate_date_of_charge');
        });
    }
}
