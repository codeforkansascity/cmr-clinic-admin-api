<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Lib\ConvertDateOfCharge;


class ConvertTextDateOfChargeToDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('convictions', function (Blueprint $table) {
            $table->renameColumn('approximate_date_of_charge', 'approximate_date_of_charge_text');
        });
        Schema::table('convictions', function (Blueprint $table) {
            $table->date('date_of_charge')->nullable();
        });

        $textDateConverter = new ConvertDateOfCharge();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('date', function (Blueprint $table) {
            Schema::table('convictions', function (Blueprint $table) {
                $table->dropColumn('date_of_charge');
            });
            Schema::table('convictions', function (Blueprint $table) {
                $table->renameColumn('approximate_date_of_charge_text', 'approximate_date_of_charge');
            });
        });
    }
}
