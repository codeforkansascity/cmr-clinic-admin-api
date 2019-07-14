<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Lib\ConvertTextDates;

class ConvertTextDatefieldsToDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->renameColumn('dob', 'dob_text');
            $table->renameColumn('license_expiration_date', 'license_expiration_date_text');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->date('dob')->nullable();
            $table->date('license_expiration_date')->nullable();
        });

        Schema::table('convictions', function (Blueprint $table) {
            $table->renameColumn('release_date', 'release_date_text');
        });
        Schema::table('convictions', function (Blueprint $table) {
            $table->date('release_date')->nullable();
        });

        $textDateConverter = new ConvertTextDates();



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('dob');
            $table->dropColumn('license_expiration_date');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->renameColumn('dob_text', 'dob');
            $table->renameColumn('license_expiration_date_text', 'license_expiration_date');
        });

        Schema::table('convictions', function (Blueprint $table) {
            $table->dropColumn('release_date');
        });
        Schema::table('convictions', function (Blueprint $table) {
            $table->renameColumn('release_date_text', 'release_date');
        });
    }
}
