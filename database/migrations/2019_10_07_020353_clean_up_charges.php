<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CleanUpCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  DROP convicted_text,  eligible_text,  please_expunge_text,
        Schema::table('charges', function (Blueprint $table) {
            $table->dropColumn('convicted_text');
            $table->dropColumn('eligible_text');
            $table->dropColumn('please_expunge_text');
            $table->unsignedBigInteger('statute_id')->nullable()->after('conviction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->dropColumn('statute_id');
            $table->string('convicted_text', 64)->nullable();
            $table->string('eligible_text', 64)->nullable();
            $table->string('please_expunge_text', 64)->nullable();

        });
    }
}
