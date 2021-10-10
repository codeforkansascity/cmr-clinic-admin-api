<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-05-31
 * Time: 23:49.
 */

namespace App\Lib;

use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InitialPermissions
{
    public function __construct()
    {
        info(__METHOD__.'START');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        try {
            $role = Role::findByName('super-admin');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'super-admin']);
        }

        Permission::findOrCreate('always fail');


        Permission::findOrCreate('CMS access');

        Permission::findOrCreate('user index');
        Permission::findOrCreate('user add');
        Permission::findOrCreate('user edit');
        Permission::findOrCreate('user view');
        Permission::findOrCreate('user delete');
        Permission::findOrCreate('user export-pdf');
        Permission::findOrCreate('user export-excel');

        Permission::findOrCreate('import_mshp_charge_code_manual index');
        Permission::findOrCreate('import_mshp_charge_code_manual view');
        Permission::findOrCreate('import_mshp_charge_code_manual export-pdf');
        Permission::findOrCreate('import_mshp_charge_code_manual export-excel');
        Permission::findOrCreate('import_mshp_charge_code_manual add');
        Permission::findOrCreate('import_mshp_charge_code_manual update');
        Permission::findOrCreate('import_mshp_charge_code_manual destroy');

        Permission::findOrCreate('import_mshp_charge_code index');
        Permission::findOrCreate('import_mshp_charge_code view');
        Permission::findOrCreate('import_mshp_charge_code export-pdf');
        Permission::findOrCreate('import_mshp_charge_code export-excel');
        Permission::findOrCreate('import_mshp_charge_code add');
        Permission::findOrCreate('import_mshp_charge_code update');
        Permission::findOrCreate('import_mshp_charge_code destroy');

        Permission::findOrCreate('invite index');
        Permission::findOrCreate('invite add');
        Permission::findOrCreate('invite edit');
        Permission::findOrCreate('invite view');
        Permission::findOrCreate('invite delete');
        Permission::findOrCreate('invite export-pdf');
        Permission::findOrCreate('invite export-excel');

        Permission::findOrCreate('applicant access-all');
        Permission::findOrCreate('applicant index');
        Permission::findOrCreate('applicant add');
        Permission::findOrCreate('applicant edit');
        Permission::findOrCreate('applicant view');
        Permission::findOrCreate('applicant delete');
        Permission::findOrCreate('applicant export-pdf');
        Permission::findOrCreate('applicant export-excel');

        Permission::findOrCreate('assignment index');
        Permission::findOrCreate('assignment add');
        Permission::findOrCreate('assignment edit');
        Permission::findOrCreate('assignment view');
        Permission::findOrCreate('assignment delete');
        Permission::findOrCreate('assignment export-pdf');
        Permission::findOrCreate('assignment export-excel');

        Permission::findOrCreate('conviction index');
        Permission::findOrCreate('conviction add');
        Permission::findOrCreate('conviction edit');
        Permission::findOrCreate('conviction view');
        Permission::findOrCreate('conviction delete');
        Permission::findOrCreate('conviction export-pdf');
        Permission::findOrCreate('conviction export-excel');

        Permission::findOrCreate('charge index');
        Permission::findOrCreate('charge add');
        Permission::findOrCreate('charge edit');
        Permission::findOrCreate('charge view');
        Permission::findOrCreate('charge delete');
        Permission::findOrCreate('charge export-pdf');
        Permission::findOrCreate('charge export-excel');

        Permission::findOrCreate('data_source index');
        Permission::findOrCreate('data_source view');
        Permission::findOrCreate('data_source export-pdf');
        Permission::findOrCreate('data_source export-excel');
        Permission::findOrCreate('data_source add');
        Permission::findOrCreate('data_source edit');
        Permission::findOrCreate('data_source delete');

        Permission::findOrCreate('exception index');
        Permission::findOrCreate('exception view');
        Permission::findOrCreate('exception export-pdf');
        Permission::findOrCreate('exception export-excel');
        Permission::findOrCreate('exception add');
        Permission::findOrCreate('exception edit');
        Permission::findOrCreate('exception delete');

        Permission::findOrCreate('jurisdiction index');
        Permission::findOrCreate('jurisdiction view');
        Permission::findOrCreate('jurisdiction export-pdf');
        Permission::findOrCreate('jurisdiction export-excel');
        Permission::findOrCreate('jurisdiction add');
        Permission::findOrCreate('jurisdiction edit');
        Permission::findOrCreate('jurisdiction delete');

        Permission::findOrCreate('jurisdiction_type index');
        Permission::findOrCreate('jurisdiction_type view');
        Permission::findOrCreate('jurisdiction_type export-pdf');
        Permission::findOrCreate('jurisdiction_type export-excel');
        Permission::findOrCreate('jurisdiction_type add');
        Permission::findOrCreate('jurisdiction_type edit');
        Permission::findOrCreate('jurisdiction_type delete');

        Permission::findOrCreate('petition_field index');
        Permission::findOrCreate('petition_field view');
        Permission::findOrCreate('petition_field export-pdf');
        Permission::findOrCreate('petition_field export-excel');
        Permission::findOrCreate('petition_field add');
        Permission::findOrCreate('petition_field update');
        Permission::findOrCreate('petition_field destroy');


        Permission::findOrCreate('step index');
        Permission::findOrCreate('step add');
        Permission::findOrCreate('step edit');
        Permission::findOrCreate('step view');
        Permission::findOrCreate('step delete');
        Permission::findOrCreate('step export-pdf');
        Permission::findOrCreate('step export-excel');

        Permission::findOrCreate('statute index');
        Permission::findOrCreate('statute add');
        Permission::findOrCreate('statute edit');
        Permission::findOrCreate('statute view');
        Permission::findOrCreate('statute delete');
        Permission::findOrCreate('statute export-pdf');
        Permission::findOrCreate('statute export-excel');

        Permission::findOrCreate('status index');
        Permission::findOrCreate('status add');
        Permission::findOrCreate('status edit');
        Permission::findOrCreate('status view');
        Permission::findOrCreate('status delete');
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
            'CMS access',

            'user index',
            'user add',
            'user edit',
            'user view',
            'user export-pdf',
            'user export-excel',

            'invite index',
            'invite add',
            'invite edit',
            'invite view',
            'invite delete',
            'invite export-pdf',
            'invite export-excel',

            'import_mshp_charge_code_manual index',
            'import_mshp_charge_code_manual view',

            'import_mshp_charge_code index',
            'import_mshp_charge_code view',

            'applicant access-all',
            'applicant index',
            'applicant add',
            'applicant edit',
            'applicant view',
            'applicant delete',
            'applicant export-pdf',
            'applicant export-excel',

            'conviction index',
            'conviction add',
            'conviction edit',
            'conviction view',
            'conviction delete',
            'conviction export-pdf',
            'conviction export-excel',

            'charge index',
            'charge add',
            'charge edit',
            'charge view',
            'charge delete',
            'charge export-pdf',
            'charge export-excel',

            'data_source index',
            'data_source add',
            'data_source edit',
            'data_source view',
            'data_source delete',
            'data_source export-pdf',
            'data_source export-excel',

            'exception index',
            'exception view',
            'exception export-pdf',
            'exception export-excel',
            'exception add',
            'exception edit',
            'exception delete',

            'jurisdiction index',
            'jurisdiction add',
            'jurisdiction edit',
            'jurisdiction view',
            'jurisdiction delete',
            'jurisdiction export-pdf',
            'jurisdiction export-excel',

            'jurisdiction_type index',
            'jurisdiction_type add',
            'jurisdiction_type edit',
            'jurisdiction_type view',
            'jurisdiction_type delete',
            'jurisdiction_type export-pdf',
            'jurisdiction_type export-excel',

            'petition_field index',
            'petition_field view',
            'petition_field export-pdf',
            'petition_field export-excel',
            'petition_field add',
            'petition_field update',
            'petition_field destroy',

            'status index',
            'status add',
            'status edit',
            'status view',
            'status delete',
            'status export-pdf',
            'status export-excel',

            'statute index',
            'statute add',
            'statute edit',
            'statute view',
            'statute delete',
            'statute export-pdf',
            'statute export-excel',

            'step index',
            'step add',
            'step edit',
            'step view',
            'step delete',
            'step export-pdf',
            'step export-excel',

            'assignment index',
            'assignment add',
            'assignment edit',
            'assignment view',
            'assignment delete',
            'assignment export-pdf',
            'assignment export-excel',

        ]);

        // Clinic Staff

        try {
            $role = Role::findByName('Clinic Staff');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'Clinic Staff']);
        }

        $role->givePermissionTo([
            'CMS access',

            'applicant access-all',
            'applicant index',
            'applicant add',
            'applicant edit',
            'applicant view',
            'applicant export-pdf',
            'applicant export-excel',

            'conviction index',
            'conviction add',
            'conviction edit',
            'conviction view',
            'conviction delete',
            'conviction export-pdf',
            'conviction export-excel',

            'charge index',
            'charge add',
            'charge edit',
            'charge view',
            'charge delete',
            'charge export-pdf',
            'charge export-excel',

            'data_source index',
            'data_source add',
            'data_source edit',
            'data_source view',
            'data_source delete',
            'data_source export-pdf',
            'data_source export-excel',

            'exception index',
            'exception view',
            'exception export-pdf',
            'exception export-excel',
            'exception add',
            'exception edit',
            'exception delete',

            'import_mshp_charge_code_manual index',
            'import_mshp_charge_code_manual view',
            'import_mshp_charge_code index',
            'import_mshp_charge_code view',

            'jurisdiction index',
            'jurisdiction add',
            'jurisdiction edit',
            'jurisdiction view',
            'jurisdiction delete',
            'jurisdiction export-pdf',
            'jurisdiction export-excel',

            'jurisdiction_type index',
            'jurisdiction_type add',
            'jurisdiction_type edit',
            'jurisdiction_type view',
            'jurisdiction_type delete',
            'jurisdiction_type export-pdf',
            'jurisdiction_type export-excel',

            'petition_field index',
            'petition_field view',
            'petition_field export-pdf',
            'petition_field export-excel',
            'petition_field add',
            'petition_field update',
            'petition_field destroy',

            'statute index',
            'statute add',
            'statute edit',
            'statute view',
            'statute delete',
            'statute export-pdf',
            'statute export-excel',

        ]);

        // Clinic Student

        try {
            $role = Role::findByName('Clinic Student');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'Clinic Student']);
        }

        $role->givePermissionTo([
            'CMS access',

            'applicant access-all',
            'applicant index',
            'applicant edit',
            'applicant view',
            'applicant export-pdf',
            'applicant export-excel',

            'conviction index',
            'conviction add',
            'conviction edit',
            'conviction view',
            'conviction export-pdf',
            'conviction export-excel',

            'charge index',
            'charge add',
            'charge edit',
            'charge view',
            'charge export-pdf',
            'charge export-excel',

            'data_source index',
            'data_source add',
            'data_source edit',
            'data_source view',
            'data_source export-pdf',
            'data_source export-excel',

            'exception index',
            'exception view',
            'exception export-pdf',
            'exception export-excel',
            'exception add',
            'exception edit',

            'import_mshp_charge_code_manual index',
            'import_mshp_charge_code_manual view',
            'import_mshp_charge_code index',
            'import_mshp_charge_code view',


            'jurisdiction index',
            'jurisdiction add',
            'jurisdiction edit',
            'jurisdiction view',
            'jurisdiction export-pdf',
            'jurisdiction export-excel',

            'jurisdiction_type index',
            'jurisdiction_type add',
            'jurisdiction_type edit',
            'jurisdiction_type view',
            'jurisdiction_type export-pdf',
            'jurisdiction_type export-excel',

            'petition_field index',
            'petition_field view',
            'petition_field export-pdf',
            'petition_field export-excel',
            'petition_field add',
            'petition_field update',

            'statute index',
            'statute add',
            'statute edit',
            'statute view',
            'statute export-pdf',
            'statute export-excel',

        ]);

        // Clinic Student Level 2

        try {
            $role = Role::findByName('Clinic Student Level 2');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'Clinic Student Level 2']);
        }

        $role->givePermissionTo([
            'CMS access',

            'applicant access-all',
            'applicant index',
            'applicant add',
            'applicant edit',
            'applicant view',
            'applicant export-pdf',
            'applicant export-excel',


            'conviction index',
            'conviction add',
            'conviction edit',
            'conviction view',
            'conviction export-pdf',
            'conviction export-excel',

            'charge index',
            'charge add',
            'charge edit',
            'charge view',
            'charge export-pdf',
            'charge export-excel',

            'data_source index',
            'data_source add',
            'data_source edit',
            'data_source view',
            'data_source export-pdf',
            'data_source export-excel',

            'exception index',
            'exception view',
            'exception export-pdf',
            'exception export-excel',
            'exception add',
            'exception edit',

            'import_mshp_charge_code_manual index',
            'import_mshp_charge_code_manual view',

            'import_mshp_charge_code index',
            'import_mshp_charge_code view',


            'jurisdiction index',
            'jurisdiction add',
            'jurisdiction edit',
            'jurisdiction view',
            'jurisdiction export-pdf',
            'jurisdiction export-excel',

            'jurisdiction_type index',
            'jurisdiction_type add',
            'jurisdiction_type edit',
            'jurisdiction_type view',
            'jurisdiction_type export-pdf',
            'jurisdiction_type export-excel',

            'petition_field index',
            'petition_field view',
            'petition_field export-pdf',
            'petition_field export-excel',
            'petition_field add',
            'petition_field update',

            'statute index',
            'statute add',
            'statute edit',
            'statute view',
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

            'exception index',
            'exception view',

            'import_mshp_charge_code_manual index',
            'import_mshp_charge_code_manual view',

            'import_mshp_charge_code index',
            'import_mshp_charge_code view',

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


        try {
            $role = Role::findByName('Volunteer Lawyer');
        } catch (RoleDoesNotExist $e) {
            $role = Role::create(['name' => 'Volunteer Lawyer']);
        }

        $role->givePermissionTo([

            'applicant index',
            'applicant edit',
            'applicant view',

            'conviction index',
            'conviction add',
            'conviction edit',
            'conviction view',
            'conviction delete',

            'charge index',
            'charge add',
            'charge edit',
            'charge view',
            'charge delete',

            'petition_field index',
            'petition_field view',
            'petition_field export-pdf',
            'petition_field export-excel',
            'petition_field add',
            'petition_field update',
            'petition_field destroy',

            'statute index',
            'statute add',
            'statute edit',
            'statute view',
            'statute export-pdf',
            'statute export-excel',
        ]);



        info(__METHOD__ . 'END');

        info(__METHOD__.'END');
    }
}
