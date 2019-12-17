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
use Spatie\Permission\Exceptions\RoleDoesNotExist;


class InitialPermissions
{
    function __construct() {


        info(__METHOD__ . 'START');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        try {
            $role = Role::findByName('super-admin');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'super-admin']);
        }


        Permission::findOrCreate( 'always fail');


        Permission::findOrCreate( 'user index');
        Permission::findOrCreate( 'user add');
        Permission::findOrCreate( 'user update');
        Permission::findOrCreate( 'user view');
        Permission::findOrCreate( 'user destroy');
        Permission::findOrCreate( 'user export-pdf');
        Permission::findOrCreate( 'user export-excel');

        Permission::findOrCreate( 'invite index');
        Permission::findOrCreate( 'invite add');
        Permission::findOrCreate( 'invite update');
        Permission::findOrCreate( 'invite view');
        Permission::findOrCreate( 'invite destroy');
        Permission::findOrCreate( 'invite export-pdf');
        Permission::findOrCreate( 'invite export-excel');

        Permission::findOrCreate( 'applicant index');
        Permission::findOrCreate( 'applicant add');
        Permission::findOrCreate( 'applicant update');
        Permission::findOrCreate( 'applicant view');
        Permission::findOrCreate( 'applicant destroy');
        Permission::findOrCreate( 'applicant export-pdf');
        Permission::findOrCreate( 'applicant export-excel');

        Permission::findOrCreate( 'assignment index');
        Permission::findOrCreate( 'assignment add');
        Permission::findOrCreate( 'assignment update');
        Permission::findOrCreate( 'assignment view');
        Permission::findOrCreate( 'assignment destroy');
        Permission::findOrCreate( 'assignment export-pdf');
        Permission::findOrCreate( 'assignment export-excel');

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

        Permission::findOrCreate('data_source index');
        Permission::findOrCreate('data_source view');
        Permission::findOrCreate('data_source export-pdf');
        Permission::findOrCreate('data_source export-excel');
        Permission::findOrCreate('data_source add');
        Permission::findOrCreate('data_source update');
        Permission::findOrCreate('data_source destroy');

        Permission::findOrCreate('jurisdiction index');
        Permission::findOrCreate('jurisdiction view');
        Permission::findOrCreate('jurisdiction export-pdf');
        Permission::findOrCreate('jurisdiction export-excel');
        Permission::findOrCreate('jurisdiction add');
        Permission::findOrCreate('jurisdiction update');
        Permission::findOrCreate('jurisdiction destroy');

        Permission::findOrCreate('jurisdiction_type index');
        Permission::findOrCreate('jurisdiction_type view');
        Permission::findOrCreate('jurisdiction_type export-pdf');
        Permission::findOrCreate('jurisdiction_type export-excel');
        Permission::findOrCreate('jurisdiction_type add');
        Permission::findOrCreate('jurisdiction_type update');
        Permission::findOrCreate('jurisdiction_type destroy');

        Permission::findOrCreate('step index');
        Permission::findOrCreate('step add');
        Permission::findOrCreate('step update');
        Permission::findOrCreate('step view');
        Permission::findOrCreate('step destroy');
        Permission::findOrCreate('step export-pdf');
        Permission::findOrCreate('step export-excel');

        Permission::findOrCreate('statute index');
        Permission::findOrCreate('statute add');
        Permission::findOrCreate('statute update');
        Permission::findOrCreate('statute view');
        Permission::findOrCreate('statute destroy');
        Permission::findOrCreate('statute export-pdf');
        Permission::findOrCreate('statute export-excel');



        Permission::findOrCreate('status index');
        Permission::findOrCreate('status add');
        Permission::findOrCreate('status update');
        Permission::findOrCreate('status view');
        Permission::findOrCreate('status destroy');
        Permission::findOrCreate('status export-pdf');
        Permission::findOrCreate('status export-excel');




        try {
            $role = Role::findByName('cant');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'cant']);
        }

        $role->givePermissionTo(['always fail']);


        try {
            $role = Role::findByName('only index');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'only index']);
        }

        $role->givePermissionTo(['applicant index']);
        $role->givePermissionTo(['conviction index']);
        $role->givePermissionTo(['charge index']);
        $role->givePermissionTo(['jurisdiction_type index']);
        $role->givePermissionTo(['statute index']);
        $role->givePermissionTo(['status index']);

        try {
            $role = Role::findByName('cmr-admin');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'cmr-admin']);
        }

        $role->givePermissionTo([
            'user index',
            'user add',
            'user update',
            'user view',
            'user destroy',
            'user export-pdf',
            'user export-excel',

            'invite index',
            'invite add',
            'invite update',
            'invite view',
            'invite destroy',
            'invite export-pdf',
            'invite export-excel',

            'applicant index',
            'applicant add',
            'applicant update',
            'applicant view',
            'applicant destroy',
            'applicant export-pdf',
            'applicant export-excel',

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



            'data_source index',
            'data_source add',
            'data_source update',
            'data_source view',
            'data_source destroy',
            'data_source export-pdf',
            'data_source export-excel',

            'jurisdiction index',
            'jurisdiction add',
            'jurisdiction update',
            'jurisdiction view',
            'jurisdiction destroy',
            'jurisdiction export-pdf',
            'jurisdiction export-excel',

            'jurisdiction_type index',
            'jurisdiction_type add',
            'jurisdiction_type update',
            'jurisdiction_type view',
            'jurisdiction_type destroy',
            'jurisdiction_type export-pdf',
            'jurisdiction_type export-excel',


            'status index',
            'status add',
            'status update',
            'status view',
            'status destroy',
            'status export-pdf',
            'status export-excel',

            'statute index',
            'statute add',
            'statute update',
            'statute view',
            'statute destroy',
            'statute export-pdf',
            'statute export-excel',

            'step index',
            'step add',
            'step update',
            'step view',
            'step destroy',
            'step export-pdf',
            'step export-excel',

            'assignment index',
            'assignment add',
            'assignment update',
            'assignment view',
            'assignment destroy',
            'assignment export-pdf',
            'assignment export-excel',

        ]);

        try {
            $role = Role::findByName('Clinic Staff');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'Clinic Staff']);
        }

        $role->givePermissionTo([

            'applicant index',
            'applicant add',
            'applicant update',
            'applicant view',
            'applicant export-pdf',
            'applicant export-excel',

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

            'data_source index',
            'data_source add',
            'data_source update',
            'data_source view',
            'data_source destroy',
            'data_source export-pdf',
            'data_source export-excel',

            'jurisdiction index',
            'jurisdiction add',
            'jurisdiction update',
            'jurisdiction view',
            'jurisdiction destroy',
            'jurisdiction export-pdf',
            'jurisdiction export-excel',


            'jurisdiction_type index',
            'jurisdiction_type add',
            'jurisdiction_type update',
            'jurisdiction_type view',
            'jurisdiction_type destroy',
            'jurisdiction_type export-pdf',
            'jurisdiction_type export-excel',

            'statute index',
            'statute add',
            'statute update',
            'statute view',
            'statute destroy',
            'statute export-pdf',
            'statute export-excel',




        ]);




        try {
            $role = Role::findByName('read-only');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'read-only']);
        }

        $role->givePermissionTo([

            'user index',


            'applicant index',
            'applicant view',

            'conviction index',
            'conviction view',

            'charge index',
            'charge view',


            'data_source index',
            'data_source view',

            'jurisdiction index',
            'jurisdiction view',

            'jurisdiction_type index',
            'jurisdiction_type view',

            'statute index',
            'statute view',

            'status index',
            'status view',

            'step index',
            'step view',

            'assignment index',
            'assignment view',
        ]);


        info(__METHOD__ . 'END');

    }
}
