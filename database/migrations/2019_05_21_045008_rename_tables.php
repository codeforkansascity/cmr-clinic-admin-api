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

        Schema::table('clients', function (Blueprint $table) {
            $table->renameColumn('full_name', 'name');
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

        Schema::table('clients', function (Blueprint $table) {
            $table->renameColumn('name', 'full_name');
            $table->dropColumn('deleted_at');
        });
        Schema::rename('clients', 'client');
        Schema::rename('convictions', 'conviction');
        Schema::rename('charges', 'charge');
    }
}
