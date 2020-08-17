<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCdlStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdl_statuses', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name', 10)->unique();
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
        });

        $status = \App\CdlStatus::create([
            'id' => \App\CdlStatus::YES,
            'name' => 'Yes',
            'sequence' => 10,
        ]);
        $status = \App\CdlStatus::create([
            'id' => \App\CdlStatus::NO,
            'name' => 'No',
            'sequence' => 20,
        ]);
        $status = \App\CdlStatus::create([
            'id' => \App\CdlStatus::UNKNOWN,
            'name' => 'Unknown',
            'sequence' => 30,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdl_statuses');
    }
}
