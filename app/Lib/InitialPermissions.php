<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-05-31
 * Time: 23:49
 */

namespace App\Lib;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class InitialPermissions
{
    function __construct() {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'super-admin']);



        Permission::create(['name' => 'always fail']);


        Permission::create(['name' => 'client index']);
        Permission::create(['name' => 'client add']);
        Permission::create(['name' => 'client update']);
        Permission::create(['name' => 'client view']);
        Permission::create(['name' => 'client destroy']);
        Permission::create(['name' => 'client export-pdf']);
        Permission::create(['name' => 'client export-excel']);


        Permission::create(['name' => 'conviction index']);
        Permission::create(['name' => 'conviction add']);
        Permission::create(['name' => 'conviction update']);
        Permission::create(['name' => 'conviction view']);
        Permission::create(['name' => 'conviction destroy']);
        Permission::create(['name' => 'conviction export-pdf']);
        Permission::create(['name' => 'conviction export-excel']);


        Permission::create(['name' => 'charge index']);
        Permission::create(['name' => 'charge add']);
        Permission::create(['name' => 'charge update']);
        Permission::create(['name' => 'charge view']);
        Permission::create(['name' => 'charge destroy']);
        Permission::create(['name' => 'charge export-pdf']);
        Permission::create(['name' => 'charge export-excel']);


        $role = Role::create(['name' => 'cant']);
        $role->givePermissionTo(['always fail']);

        $role = Role::create(['name' => 'only index']);                 // For Testing
        $role->givePermissionTo(['client index']);
        $role->givePermissionTo(['conviction index']);
        $role->givePermissionTo(['charge index']);

        $role = Role::create(['name' => 'cmr-admin']);
        $role->givePermissionTo([
            'client index',
            'client add',
            'client update',
            'client view',
            'client destroy',
            'client export-pdf',
            'client export-excel',

            'conviction index',
            'conviction add',
            'conviction update',
            'conviction view',
            'conviction destroy',
            'conviction export-pdf',
            'conviction export-excel',

            'charge index',
            'charge add',
            'charge update',
            'charge view',
            'charge destroy',
            'charge export-pdf',
            'charge export-excel',

        ]);



        $role = Role::create(['name' => 'read-only']);

        $role->givePermissionTo([
            'client index',
            'client view',

            'conviction index',
            'conviction view',

            'charge index',
            'charge view',
        ]);

    }
}
