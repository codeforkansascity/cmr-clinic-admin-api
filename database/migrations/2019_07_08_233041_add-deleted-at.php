<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('convictions', function (Blueprint $table) {
            $table->unsignedBigInteger('deleted_at')->nullable();
        });
        Schema::table('charges', function (Blueprint $table) {
            $table->unsignedBigInteger('deleted_at')->nullable();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('convictions', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('charges', function (Blueprint $table) {
            $table->dropColumn('deleted_at')->default(0);
        });

    }
}
