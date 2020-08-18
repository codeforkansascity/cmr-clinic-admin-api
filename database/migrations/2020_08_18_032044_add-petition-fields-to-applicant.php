<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPetitionFieldsToApplicant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {

            $table->string('case_heading')->nullable();
            $table->string('case_no')->nullable();
            $table->string('counsel_or_pro_se_statment')->nullable();
            $table->string('signature_block_heading')->nullable();
            $table->string('signature_block_name')->nullable();
            $table->string('signature_block_bar_number_or_pro_se')->nullable();
            $table->string('signature_block_address')->nullable();
            $table->string('signature_block_city_state_zip')->nullable();
            $table->string('signature_block_phone')->nullable();
            $table->string('signature_block_email')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn('case_heading');
            $table->dropColumn('case_no');
            $table->dropColumn('counsel_or_pro_se_statment');
            $table->dropColumn('signature_block_heading');
            $table->dropColumn('signature_block_name');
            $table->dropColumn('signature_block_bar_number_or_pro_se');
            $table->dropColumn('signature_block_address');
            $table->dropColumn('signature_block_city_state_zip');
            $table->dropColumn('signature_block_phone');
            $table->dropColumn('signature_block_email');

        });
    }
}
