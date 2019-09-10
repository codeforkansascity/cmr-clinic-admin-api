<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDeletedAtToTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->dropColumn('deleted_at');

        });
        Schema::table('charges', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('convictions', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('convictions', function (Blueprint $table) {
            $table->softDeletes();
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
            $table->dropColumn('deleted_at');
        });
        Schema::table('charges', function (Blueprint $table) {

            $table->unsignedBigInteger('deleted_at')->nullable();
        });

        Schema::table('convictions', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('convictions', function (Blueprint $table) {
            $table->unsignedBigInteger('deleted_at')->nullable();
        });
    }
}
