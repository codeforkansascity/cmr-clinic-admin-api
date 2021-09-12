<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMshpVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('mshp_versions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('system_name');
            $table->date('effective_date')->nullable();
            $table->timestamps();
        });

        DB::connection()->getPdo()->exec('insert into mshp_versions (id, name, system_name, effective_date) values (1,"2020-2021","2020","2020-08-28") ;');
        DB::connection()->getPdo()->exec('insert into mshp_versions (id, name, system_name, effective_date) values (2,"2021-2022","2021","2021-08-28") ;');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mshp_versions');
    }
}
