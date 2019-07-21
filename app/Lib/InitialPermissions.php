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



        Permission::findOrCreate( 'always fail');


        Permission::findOrCreate( 'user index');
        Permission::findOrCreate( 'user add');
        Permission::findOrCreate( 'user update');
        Permission::findOrCreate( 'user view');
        Permission::findOrCreate( 'user destroy');
        Permission::findOrCreate( 'user export-pdf');
        Permission::findOrCreate( 'user export-excel');

        Permission::findOrCreate( 'client index');
        Permission::findOrCreate( 'client add');
        Permission::findOrCreate( 'client update');
        Permission::findOrCreate( 'client view');
        Permission::findOrCreate( 'client destroy');
        Permission::findOrCreate( 'client export-pdf');
        Permission::findOrCreate( 'client export-excel');


        Permission::findOrCreate( 'conviction index');
        Permission::findOrCreate( 'conviction add');
        Permission::findOrCreate( 'conviction update');
        Permission::findOrCreate( 'conviction view');
        Permission::findOrCreate( 'conviction destroy');
        Permission::findOrCreate( 'conviction export-pdf');
        Permission::findOrCreate( 'conviction export-excel');


        Permission::findOrCreate( 'charge index');
        Permission::findOrCreate( 'charge add');
        Permission::findOrCreate( 'charge update');
        Permission::findOrCreate( 'charge view');
        Permission::findOrCreate( 'charge destroy');
        Permission::findOrCreate( 'charge export-pdf');
        Permission::findOrCreate( 'charge export-excel');

        Permission::findOrCreate('status index');
        Permission::findOrCreate('status add');
        Permission::findOrCreate('status update');
        Permission::findOrCreate('status view');
        Permission::findOrCreate('status destroy');
        Permission::findOrCreate('status export-pdf');
        Permission::findOrCreate('status export-excel');

        Permission::findOrCreate( 'assignment index');
        Permission::findOrCreate( 'assignment add');
        Permission::findOrCreate( 'assignment update');
        Permission::findOrCreate( 'assignment view');
        Permission::findOrCreate( 'assignment destroy');
        Permission::findOrCreate( 'assignment export-pdf');
        Permission::findOrCreate( 'assignment export-excel');


        $role = Role::create(['name' => 'cant']);
        $role->givePermissionTo(['always fail']);

        $role = Role::create(['name' => 'only index']);                 // For Testing
        $role->givePermissionTo(['client index']);
        $role->givePermissionTo(['conviction index']);
        $role->givePermissionTo(['charge index']);
        $role->givePermissionTo(['status index']);

        $role = Role::create(['name' => 'cmr-admin']);
        $role->givePermissionTo([
            'user index',
            'user add',
            'user update',
            'user view',
            'user destroy',
            'user export-pdf',
            'user export-excel',

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

            'status index',
            'status add',
            'status update',
            'status view',
            'status destroy',
            'status export-pdf',
            'status export-excel',

            'assignment index',
            'assignment add',
            'assignment update',
            'assignment view',
            'assignment destroy',
            'assignment export-pdf',
            'assignment export-excel',

        ]);



        $role = Role::create(['name' => 'read-only']);

        $role->givePermissionTo([

            'user index',
            'user view',

            'client index',
            'client view',

            'conviction index',
            'conviction view',

            'charge index',
            'charge view',

            'status index',
            'status view',

            'assignment index',
            'assignment view',
        ]);

    }
}
