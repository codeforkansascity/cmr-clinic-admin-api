<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\JurisdictionType;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class JurisdictionTypeControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class JurisdictionTypeControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_jurisdiction_type_index()
    {
        $response = $this->get('/jurisdiction-type');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_jurisdiction_type()
    {
        $response = $this->get(route('jurisdiction-type.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_jurisdiction_type()
    {
        $response = $this->get(route('jurisdiction-type.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_jurisdiction_type()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('jurisdiction-type.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_jurisdiction_type()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('jurisdiction-type.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_jurisdiction_type()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('jurisdiction-type.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_jurisdiction_type()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('jurisdiction-type.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_jurisdiction_type_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/jurisdiction-type');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_jurisdiction_type()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('jurisdiction-type.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_jurisdiction_type()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('jurisdiction-type.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_jurisdiction_type()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('jurisdiction-type.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_jurisdiction_type()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('jurisdiction-type.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_jurisdiction_type()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('jurisdiction-type.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_jurisdiction_type()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('jurisdiction-type.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_jurisdiction_type()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('jurisdiction-type.create'));

        $response->assertRedirect('jurisdiction-type');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_jurisdiction_type()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('jurisdiction-type.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_jurisdiction_type()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('jurisdiction-type.show', ['id' => 1]));

        $response->assertRedirect('jurisdiction-type');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_jurisdiction_type()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('jurisdiction-type.edit', ['id' => 1]));

        $response->assertRedirect('jurisdiction-type');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_jurisdiction_type()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('jurisdiction-type.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_jurisdiction_type()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('jurisdiction-type.destroy', ['id' => 1]));

        $response->assertRedirect('jurisdiction-type');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_jurisdiction_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('jurisdiction-type.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Jurisdiction Type to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_jurisdiction_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('jurisdiction-type.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Jurisdiction Type to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_jurisdiction_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('jurisdiction-type.create'));

        $response->assertStatus(200);
        $response->assertViewIs('jurisdiction-type.create');
        $response->assertSee('jurisdiction-type-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_jurisdiction_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "",
            'display_sequence' => "",
        ];

        $totalNumberOfJurisdictionTypesBefore = JurisdictionType::count();

        $response = $this->actingAs($user)->post(route('jurisdiction-type.store'), $data);

        $totalNumberOfJurisdictionTypesAfter = JurisdictionType::count();
        $this->assertEquals($totalNumberOfJurisdictionTypesAfter, $totalNumberOfJurisdictionTypesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_jurisdiction_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "a",
            'display_sequence' => "a",
        ];

        $totalNumberOfJurisdictionTypesBefore = JurisdictionType::count();

        $response = $this->actingAs($user)->post(route('jurisdiction-type.store'), $data);

        $totalNumberOfJurisdictionTypesAfter = JurisdictionType::count();
        $this->assertEquals($totalNumberOfJurisdictionTypesAfter, $totalNumberOfJurisdictionTypesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_jurisdiction_type()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'name' => $faker->name,
          'display_sequence' => "",
        ];

        info('--  JurisdictionType  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfJurisdictionTypesBefore = JurisdictionType::count();

        $response = $this->actingAs($user)->post(route('jurisdiction-type.store'), $data);

        $totalNumberOfJurisdictionTypesAfter = JurisdictionType::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfJurisdictionTypesAfter, $totalNumberOfJurisdictionTypesBefore + 1, "the number of total jurisdiction_type is supposed to be one more ");

        $lastInsertedInTheDB = JurisdictionType::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved jurisdiction_type is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->display_sequence, $data['display_sequence'], "the display_sequence of the saved jurisdiction_type is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_jurisdiction_type()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfJurisdictionTypesBefore = JurisdictionType::count();

        $jurisdiction_type = JurisdictionType::get()->random();
        $data = [
            'id' => "",
            'name' => $jurisdiction_type->name,
            'display_sequence' => "",
        ];

        $response = $this->actingAs($user)->post(route('jurisdiction-type.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfJurisdictionTypesAfter = JurisdictionType::count();
        $this->assertEquals($totalNumberOfJurisdictionTypesAfter, $totalNumberOfJurisdictionTypesBefore, "the number of total jurisdiction_type should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_jurisdiction_type()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = JurisdictionType::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfJurisdictionTypesBefore = JurisdictionType::count();

        $response = $this->actingAs($user)->json('PATCH', 'jurisdiction-type/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfJurisdictionTypesAfter = JurisdictionType::count();
        $this->assertEquals($totalNumberOfJurisdictionTypesAfter, $totalNumberOfJurisdictionTypesBefore, "the number of total jurisdiction_type should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_jurisdiction_type()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = JurisdictionType::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one jurisdiction_type record
        $jurisdiction_type_dup = [

            'name' => $faker->name,
            'display_sequence' => "",
        ];

        $response = $this->actingAs($user)->post(route('jurisdiction-type.store'), $jurisdiction_type_dup);


        $data['name'] = $jurisdiction_type_dup['name'];

        $totalNumberOfJurisdictionTypesBefore = JurisdictionType::count();

        $response = $this->actingAs($user)->json('PATCH', 'jurisdiction-type/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfJurisdictionTypesAfter = JurisdictionType::count();
        $this->assertEquals($totalNumberOfJurisdictionTypesAfter, $totalNumberOfJurisdictionTypesBefore, "the number of total jurisdiction_type should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_jurisdiction_type()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = JurisdictionType::get()->random()->toArray();


        $totalNumberOfJurisdictionTypesBefore = JurisdictionType::count();

        $response = $this->actingAs($user)->json('DELETE', 'jurisdiction-type/' . $data['id'], $data);

        $totalNumberOfJurisdictionTypesAfter = JurisdictionType::count();
        $this->assertEquals($totalNumberOfJurisdictionTypesAfter, $totalNumberOfJurisdictionTypesBefore - 1, "the number of total jurisdiction_type should be the same ");

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
