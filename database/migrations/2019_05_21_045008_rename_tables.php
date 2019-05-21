<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('client', 'clients');
        Schema::rename('conviction', 'convictions');
        Schema::rename('charge', 'charges');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('clients', 'client');
        Schema::rename('convictions', 'conviction');
        Schema::rename('charges', 'charge');
    }
}
