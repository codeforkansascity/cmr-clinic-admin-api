<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CleanUpReleaseDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->date('release_date')->nullable()->after('sentence');
        });

        DB::connection()->getPdo()->exec('update charges c inner join convictions s on c.conviction_id = s.id set c.release_date = s.release_date;');

        Schema::table('convictions', function (Blueprint $table) {
            $table->dropColumn('release_date');
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
            $table->dropColumn('release_date');
        });

        Schema::table('convictions', function (Blueprint $table) {
            $table->date('release_date')->nullable();
        });
    }
}
