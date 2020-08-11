<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameClientsToApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            Schema::rename('clients', 'applicants');
        });

        Schema::table('convictions', function (Blueprint $table) {
            $table->renameColumn('client_id', 'applicant_id');
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
            Schema::rename('applicants', 'clients');
        });

        Schema::table('convictions', function (Blueprint $table) {
            $table->renameColumn('applicant_id', 'client_id');
        });
    }
}
