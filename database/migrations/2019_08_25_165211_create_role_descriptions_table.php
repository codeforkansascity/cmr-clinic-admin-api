<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_descriptions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('role_id')->default(0);
            $table->string('role_name',191);

            $table->string('name',191);
            $table->text('description')->nullable();
            $table->integer('sequence')->default(0);
            $table->string('roles_that_can_assign', 255)->nullable()->default('');

            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();

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
        Schema::dropIfExists('role_descriptions');
    }
}
