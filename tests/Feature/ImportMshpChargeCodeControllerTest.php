<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\ImportMshpChargeCode;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class ImportMshpChargeCodeControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class ImportMshpChargeCodeControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_import_mshp_charge_code_index()
    {
        $response = $this->get('/import-mshp-charge-code');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_import_mshp_charge_code()
    {
        $response = $this->get(route('import-mshp-charge-code.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_import_mshp_charge_code()
    {
        $response = $this->get(route('import-mshp-charge-code.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_import_mshp_charge_code()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('import-mshp-charge-code.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_import_mshp_charge_code()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('import-mshp-charge-code.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_import_mshp_charge_code()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('import-mshp-charge-code.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_import_mshp_charge_code()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('import-mshp-charge-code.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_import_mshp_charge_code_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/import-mshp-charge-code');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('import-mshp-charge-code.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('import-mshp-charge-code.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('import-mshp-charge-code.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('import-mshp-charge-code.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('import-mshp-charge-code.create'));

        $response->assertRedirect('import-mshp-charge-code');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code.show', ['id' => 1]));

        $response->assertRedirect('import-mshp-charge-code');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('import-mshp-charge-code.edit', ['id' => 1]));

        $response->assertRedirect('import-mshp-charge-code');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('import-mshp-charge-code.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_import_mshp_charge_code()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('import-mshp-charge-code.destroy', ['id' => 1]));

        $response->assertRedirect('import-mshp-charge-code');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_import_mshp_charge_code()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Charge Codes to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_import_mshp_charge_code()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Charge Codes to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_import_mshp_charge_code()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('import-mshp-charge-code.create'));

        $response->assertStatus(200);
        $response->assertViewIs('import-mshp-charge-code.create');
        $response->assertSee('import-mshp-charge-code-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_import_mshp_charge_code()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'mshp_version_id' => "",
            'legacy_charge_code' => "",
            'charge_type' => "",
            'classification' => "",
            'effective_date' => "",
            'inactive_date' => "",
            'short_description' => "",
            'charge_code' => "",
        ];

        $totalNumberOfImportMshpChargeCodesBefore = ImportMshpChargeCode::count();

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code.store'), $data);

        $totalNumberOfImportMshpChargeCodesAfter = ImportMshpChargeCode::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodesAfter, $totalNumberOfImportMshpChargeCodesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_import_mshp_charge_code()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'mshp_version_id' => "a",
            'legacy_charge_code' => "a",
            'charge_type' => "a",
            'classification' => "a",
            'effective_date' => "a",
            'inactive_date' => "a",
            'short_description' => "a",
            'charge_code' => "a",
        ];

        $totalNumberOfImportMshpChargeCodesBefore = ImportMshpChargeCode::count();

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code.store'), $data);

        $totalNumberOfImportMshpChargeCodesAfter = ImportMshpChargeCode::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodesAfter, $totalNumberOfImportMshpChargeCodesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_import_mshp_charge_code()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'mshp_version_id' => "",
          'legacy_charge_code' => "",
          'charge_type' => "",
          'classification' => "",
          'effective_date' => "",
          'inactive_date' => "",
          'short_description' => "",
          'charge_code' => "",
        ];

        info('--  ImportMshpChargeCode  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfImportMshpChargeCodesBefore = ImportMshpChargeCode::count();

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code.store'), $data);

        $totalNumberOfImportMshpChargeCodesAfter = ImportMshpChargeCode::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfImportMshpChargeCodesAfter, $totalNumberOfImportMshpChargeCodesBefore + 1, "the number of total import_mshp_charge_code is supposed to be one more ");

        $lastInsertedInTheDB = ImportMshpChargeCode::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->mshp_version_id, $data['mshp_version_id'], "the mshp_version_id of the saved import_mshp_charge_code is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->legacy_charge_code, $data['legacy_charge_code'], "the legacy_charge_code of the saved import_mshp_charge_code is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->charge_type, $data['charge_type'], "the charge_type of the saved import_mshp_charge_code is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->classification, $data['classification'], "the classification of the saved import_mshp_charge_code is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->effective_date, $data['effective_date'], "the effective_date of the saved import_mshp_charge_code is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->inactive_date, $data['inactive_date'], "the inactive_date of the saved import_mshp_charge_code is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->short_description, $data['short_description'], "the short_description of the saved import_mshp_charge_code is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->charge_code, $data['charge_code'], "the charge_code of the saved import_mshp_charge_code is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_import_mshp_charge_code()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfImportMshpChargeCodesBefore = ImportMshpChargeCode::count();

        $import_mshp_charge_code = ImportMshpChargeCode::get()->random();
        $data = [
            'id' => "",
            'mshp_version_id' => "",
            'legacy_charge_code' => "",
            'charge_type' => "",
            'classification' => "",
            'effective_date' => "",
            'inactive_date' => "",
            'short_description' => "",
            'charge_code' => "",
        ];

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfImportMshpChargeCodesAfter = ImportMshpChargeCode::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodesAfter, $totalNumberOfImportMshpChargeCodesBefore, "the number of total import_mshp_charge_code should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_import_mshp_charge_code()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = ImportMshpChargeCode::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfImportMshpChargeCodesBefore = ImportMshpChargeCode::count();

        $response = $this->actingAs($user)->json('PATCH', 'import-mshp-charge-code/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfImportMshpChargeCodesAfter = ImportMshpChargeCode::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodesAfter, $totalNumberOfImportMshpChargeCodesBefore, "the number of total import_mshp_charge_code should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_import_mshp_charge_code()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = ImportMshpChargeCode::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one import_mshp_charge_code record
        $import_mshp_charge_code_dup = [

            'mshp_version_id' => "",
            'legacy_charge_code' => "",
            'charge_type' => "",
            'classification' => "",
            'effective_date' => "",
            'inactive_date' => "",
            'short_description' => "",
            'charge_code' => "",
        ];

        $response = $this->actingAs($user)->post(route('import-mshp-charge-code.store'), $import_mshp_charge_code_dup);


        $data['name'] = $import_mshp_charge_code_dup['name'];

        $totalNumberOfImportMshpChargeCodesBefore = ImportMshpChargeCode::count();

        $response = $this->actingAs($user)->json('PATCH', 'import-mshp-charge-code/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfImportMshpChargeCodesAfter = ImportMshpChargeCode::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodesAfter, $totalNumberOfImportMshpChargeCodesBefore, "the number of total import_mshp_charge_code should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_import_mshp_charge_code()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = ImportMshpChargeCode::get()->random()->toArray();


        $totalNumberOfImportMshpChargeCodesBefore = ImportMshpChargeCode::count();

        $response = $this->actingAs($user)->json('DELETE', 'import-mshp-charge-code/' . $data['id'], $data);

        $totalNumberOfImportMshpChargeCodesAfter = ImportMshpChargeCode::count();
        $this->assertEquals($totalNumberOfImportMshpChargeCodesAfter, $totalNumberOfImportMshpChargeCodesBefore - 1, "the number of total import_mshp_charge_code should be the same ");

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
