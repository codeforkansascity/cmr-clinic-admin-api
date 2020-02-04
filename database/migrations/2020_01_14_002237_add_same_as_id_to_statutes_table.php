<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSameAsIdToStatutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statutes', function (Blueprint $table) {
            $table->unsignedBigInteger('same_as_id')->nullable();
            $table->foreign('same_as_id')
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
        Schema::table('statutes', function (Blueprint $table) {
            $table->dropForeign('same_as_id');
        });
    }
}
