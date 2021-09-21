<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatueExceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statute_exceptions', function (Blueprint $table) {
            $table->text('attorney_note')->nullable();
            $table->text('dyi_note')->nullable();
            $table->text('source')->default(null)->nullable();
            $table->integer('exception_code_id')->default(null)->nullable();

        });
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
