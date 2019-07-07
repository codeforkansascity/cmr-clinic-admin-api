<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 60)->unique();
            $table->string('alias', 12)->default('')->nullable();
            $table->integer('sequence')->default(0)->nullable();
            $table->integer('created_by')->default(0)->nullable();
            $table->integer('modified_by')->default(0)->nullable();
            $table->integer('purged_by')->default(0)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->integer('status_id')->default(0)->nullable();
        });

        $status = \App\Status::create([
            'name' => 'Applicant Added',
            'alias' => 'Added',
            'sequence' => 10,
        ]);
        $status = \App\Status::create([
            'name' => 'Criminal History Entered',
            'alias' => 'Entered',
            'sequence' => 20,
        ]);
        $status = \App\Status::create([
            'name' => 'Criminal History Reviewed',
            'alias' => 'Reviewed',
            'sequence' => 30,
        ]);
        $status = \App\Status::create([
            'name' => 'Meet with Client',
            'alias' => 'Meet',
            'sequence' => 70,
        ]);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::findOrCreate('status index');
        Permission::findOrCreate('status add');
        Permission::findOrCreate('status update');
        Permission::findOrCreate('status view');
        Permission::findOrCreate('status destroy');
        Permission::findOrCreate('status export-pdf');
        Permission::findOrCreate('status export-excel');

        $this->addRole('only index', 'status index');
        $this->addRole('cmr-admin', [
                'status index',
                'status add',
                'status update',
                'status view',
                'status destroy',
                'status export-pdf',
                'status export-excel'
            ]
        );
        $this->addRole('read-only', [
                'status index',
                'status view',
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });

    }

    private function addRole($role, $permissions)
    {

        try {
            $role = Role::findByName($role);
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        $role->givePermissionTo($permissions);

    }
}
