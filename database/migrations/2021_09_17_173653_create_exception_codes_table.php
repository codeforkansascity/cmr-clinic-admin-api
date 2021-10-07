<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExceptionCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exception_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sequence')->default(0)->nullable();
            $table->string('system_name');
            $table->timestamps();
        });

        $status = \App\ExceptionCodes::create([
            'id' => \App\ExceptionCodes::APPLIES,
            'name' => 'Applies',
            'code' => 'A',
            'system_name' => 'applies',
            'sequence' => 10,
        ]);

        $status = \App\ExceptionCodes::create([
            'id' => \App\ExceptionCodes::POSSIBLY_APPLIES,
            'name' => 'Possibly Applies',
            'code' => 'P',
            'system_name' => 'possibly_applies',
            'sequence' => 20,
        ]);

        $status = \App\ExceptionCodes::create([
            'id' => \App\ExceptionCodes::DOES_NOT_APPLY,
            'name' => 'Does Not Apply',
            'code' => 'D',
            'system_name' => 'does_not_apply',
            'sequence' => 30,
        ]);
        
        $status = \App\ExceptionCodes::create([
            'id' => \App\ExceptionCodes::RESEARCH,
            'name' => 'Research',
            'code' => 'R',
            'system_name' => 'research',
            'sequence' => 40,
        ]);

        $status = \App\ExceptionCodes::create([
            'id' => \App\ExceptionCodes::UNDETERMINED,
            'name' => 'Undetermined',
            'code' => 'U',
            'system_name' => 'undetermined',
            'sequence' => 50,
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exception_codes');
    }
}
