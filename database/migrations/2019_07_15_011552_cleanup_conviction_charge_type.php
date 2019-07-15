<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CleanupConvictionChargeType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /// update charges set conviction_charge_type = 'Misdemeanor' where conviction_charge_type = 'misdemeanor';

        DB::connection()->getPdo()->exec('update charges set conviction_charge_type = \'Misdemeanor\' where conviction_charge_type = \'misdemeanor\';');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
