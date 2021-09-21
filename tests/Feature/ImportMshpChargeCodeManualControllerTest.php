<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\ImportMshpChargeCodeManual;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class ImportMshpChargeCodeManualControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class ImportMshpChargeCodeManualControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_import_mshp_charge_code_manual_index()
    {
        $response = $this->get('/import-mshp-charge-code-manual');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_import_mshp_charge_code_manual()
    {
        $response = $this->get(route('import-mshp-charge-code-manual.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_import_mshp_charge_code_manual()
    {
        $response = $this->get(route('import-mshp-charge-code-manual.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_import_mshp_charge_code_manual()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('import-mshp-charge-code-manual.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_import_mshp_charge_code_manual()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('import-mshp-charge-code-manual.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_import_mshp_charge_code_manual()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('import-mshp-charge-code-manual.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_import_mshp_charge_code_manual()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('import-mshp-charge-code-manual.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_import_mshp_charge_code_manual_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/import-mshp-charge-code-manual');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('import-mshp-charge-code-manual.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code-manual.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code-manual.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('import-mshp-charge-code-manual.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('import-mshp-charge-code-manual.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('import-mshp-charge-code-manual.destroy', ['id' => 1]));

        $response->assertRedirect('home');
    }

    ////////////

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions
    //   user does have access to index
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_creating_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('import-mshp-charge-code-manual.create'));

        $response->assertRedirect('import-mshp-charge-code-manual');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code-manual.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code-manual.show', ['id' => 1]));

        $response->assertRedirect('import-mshp-charge-code-manual');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('import-mshp-charge-code-manual.edit', ['id' => 1]));

        $response->assertRedirect('import-mshp-charge-code-manual');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('import-mshp-charge-code-manual.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_import_mshp_charge_code_manual()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('import-mshp-charge-code-manual.destroy', ['id' => 1]));

        $response->assertRedirect('import-mshp-charge-code-manual');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_import_mshp_charge_code_manual()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code-manual.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Charge Codes to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_import_mshp_charge_code_manual()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code-manual.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Charge Codes to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_import_mshp_charge_code_manual()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code-manual.create'));

        $response->assertStatus(200);
        $response->assertViewIs('import-mshp-charge-code-manual.create');
        $response->assertSee('import-mshp-charge-code-manual-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_import_mshp_charge_code_manual()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'mshp_version_id' => "",
            'charge_code' => "",
            'ncic_mod' => "",
            'state_mod' => "",
            'description' => "",
            'type_class' => "",
            'dna' => "",
            'sor' => "",
            'roc' => "",
        ];

        $totalNumberOfImportMshpChargeCodeManualsBefore = ImportMshpChargeCodeManual::count();

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code-manual.store'), $data);

        $totalNumberOfImportMshpChargeCodeManualsAfter = ImportMshpChargeCodeManual::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodeManualsAfter, $totalNumberOfImportMshpChargeCodeManualsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_import_mshp_charge_code_manual()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'mshp_version_id' => "a",
            'charge_code' => "a",
            'ncic_mod' => "a",
            'state_mod' => "a",
            'description' => "a",
            'type_class' => "a",
            'dna' => "a",
            'sor' => "a",
            'roc' => "a",
        ];

        $totalNumberOfImportMshpChargeCodeManualsBefore = ImportMshpChargeCodeManual::count();

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code-manual.store'), $data);

        $totalNumberOfImportMshpChargeCodeManualsAfter = ImportMshpChargeCodeManual::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodeManualsAfter, $totalNumberOfImportMshpChargeCodeManualsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_import_mshp_charge_code_manual()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'mshp_version_id' => "",
          'charge_code' => "",
          'ncic_mod' => "",
          'state_mod' => "",
          'description' => "",
          'type_class' => "",
          'dna' => "",
          'sor' => "",
          'roc' => "",
        ];

        info('--  ImportMshpChargeCodeManual  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfImportMshpChargeCodeManualsBefore = ImportMshpChargeCodeManual::count();

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code-manual.store'), $data);

        $totalNumberOfImportMshpChargeCodeManualsAfter = ImportMshpChargeCodeManual::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfImportMshpChargeCodeManualsAfter, $totalNumberOfImportMshpChargeCodeManualsBefore + 1, "the number of total import_mshp_charge_code_manual is supposed to be one more ");

        $lastInsertedInTheDB = ImportMshpChargeCodeManual::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->mshp_version_id, $data['mshp_version_id'], "the mshp_version_id of the saved import_mshp_charge_code_manual is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->charge_code, $data['charge_code'], "the charge_code of the saved import_mshp_charge_code_manual is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->ncic_mod, $data['ncic_mod'], "the ncic_mod of the saved import_mshp_charge_code_manual is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->state_mod, $data['state_mod'], "the state_mod of the saved import_mshp_charge_code_manual is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->description, $data['description'], "the description of the saved import_mshp_charge_code_manual is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->type_class, $data['type_class'], "the type_class of the saved import_mshp_charge_code_manual is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->dna, $data['dna'], "the dna of the saved import_mshp_charge_code_manual is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->sor, $data['sor'], "the sor of the saved import_mshp_charge_code_manual is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->roc, $data['roc'], "the roc of the saved import_mshp_charge_code_manual is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_import_mshp_charge_code_manual()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfImportMshpChargeCodeManualsBefore = ImportMshpChargeCodeManual::count();

        $import_mshp_charge_code_manual = ImportMshpChargeCodeManual::get()->random();
        $data = [
            'id' => "",
            'mshp_version_id' => "",
            'charge_code' => "",
            'ncic_mod' => "",
            'state_mod' => "",
            'description' => "",
            'type_class' => "",
            'dna' => "",
            'sor' => "",
            'roc' => "",
        ];

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code-manual.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfImportMshpChargeCodeManualsAfter = ImportMshpChargeCodeManual::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodeManualsAfter, $totalNumberOfImportMshpChargeCodeManualsBefore, "the number of total import_mshp_charge_code_manual should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_import_mshp_charge_code_manual()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = ImportMshpChargeCodeManual::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfImportMshpChargeCodeManualsBefore = ImportMshpChargeCodeManual::count();

        $response = $this->actingAs($user)->json('PATCH', 'import-mshp-charge-code-manual/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfImportMshpChargeCodeManualsAfter = ImportMshpChargeCodeManual::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodeManualsAfter, $totalNumberOfImportMshpChargeCodeManualsBefore, "the number of total import_mshp_charge_code_manual should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_import_mshp_charge_code_manual()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = ImportMshpChargeCodeManual::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one import_mshp_charge_code_manual record
        $import_mshp_charge_code_manual_dup = [

            'mshp_version_id' => "",
            'charge_code' => "",
            'ncic_mod' => "",
            'state_mod' => "",
            'description' => "",
            'type_class' => "",
            'dna' => "",
            'sor' => "",
            'roc' => "",
        ];

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code-manual.store'), $import_mshp_charge_code_manual_dup);


        $data['name'] = $import_mshp_charge_code_manual_dup['name'];

        $totalNumberOfImportMshpChargeCodeManualsBefore = ImportMshpChargeCodeManual::count();

        $response = $this->actingAs($user)->json('PATCH', 'import-mshp-charge-code-manual/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfImportMshpChargeCodeManualsAfter = ImportMshpChargeCodeManual::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodeManualsAfter, $totalNumberOfImportMshpChargeCodeManualsBefore, "the number of total import_mshp_charge_code_manual should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_import_mshp_charge_code_manual()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = ImportMshpChargeCodeManual::get()->random()->toArray();


        $totalNumberOfImportMshpChargeCodeManualsBefore = ImportMshpChargeCodeManual::count();

        $response = $this->actingAs($user)->json('DELETE', 'import-mshp-charge-code-manual/' . $data['id'], $data);

        $totalNumberOfImportMshpChargeCodeManualsAfter = ImportMshpChargeCodeManual::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodeManualsAfter, $totalNumberOfImportMshpChargeCodeManualsBefore - 1, "the number of total import_mshp_charge_code_manual should be the same ");

    }

    /**
     * Get a random user with optional role and guard
     *
     * @param null $role
     * @param string $guard
     * @return mixed
     */
    public function getRandomUser($role = null, $guard = 'web')
    {

        if ($role) {

            // This should work but throws a 'Spatie\Permission\Exceptions\RoleDoesNotExist: There is no role named `super-admin`.
            $role_id = Role::findByName($role,'web')->id;

            $sql = "SELECT model_id FROM model_has_roles WHERE model_type = 'App\\\User' AND role_id = $role_id ORDER BY RAND() LIMIT 1";
            $ret = DB::select($sql);
            $user_id = $ret[0]->model_id;

            $this->user = User::find($user_id);
        } else {
            $this->user = User::get()->random();
        }

        return $this->user;
    }


}
