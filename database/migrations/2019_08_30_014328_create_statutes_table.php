<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statutes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('name', 500);
            $table->text('note')->nullable();
            $table->string('eligible')->nullable();
            $table->index(['eligible']);
            $table->timestamps();
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
        Schema::dropIfExists('statutes');
    }
}