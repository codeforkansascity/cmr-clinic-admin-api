<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Lib\SetYesNoLib;

class SetYesNoMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('charges', function (Blueprint $table) {
            $table->renameColumn('convicted', 'convicted_text');
            $table->renameColumn('eligible', 'eligible_text');
            $table->renameColumn('please_expunge', 'please_expunge_text');

        });
        Schema::table('charges', function (Blueprint $table) {
            $table->boolean('convicted')->nullable();
            $table->boolean('eligible')->nullable();
            $table->boolean('please_expunge')->nullable();

        });

        $a = new SetYesNoLib();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->dropColumn('convicted');
            $table->dropColumn('eligible');
            $table->dropColumn('please_expunge');
        });
        Schema::table('charges', function (Blueprint $table) {
            $table->renameColumn('convicted_text', 'convicted');
            $table->renameColumn('eligible_text', 'eligible');
            $table->renameColumn('please_expunge_text', 'please_expunge');
        });
    }
}
