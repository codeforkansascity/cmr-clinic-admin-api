<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Jurisdiction;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class JurisdictionControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class JurisdictionControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_jurisdiction_index()
    {
        $response = $this->get('/jurisdiction');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_jurisdiction()
    {
        $response = $this->get(route('jurisdiction.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_jurisdiction()
    {
        $response = $this->get(route('jurisdiction.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_jurisdiction()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('jurisdiction.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_jurisdiction()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('jurisdiction.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_jurisdiction()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('jurisdiction.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_jurisdiction()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('jurisdiction.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_jurisdiction_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/jurisdiction');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_jurisdiction()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('jurisdiction.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_jurisdiction()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('jurisdiction.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_jurisdiction()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('jurisdiction.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_jurisdiction()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('jurisdiction.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_jurisdiction()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('jurisdiction.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_jurisdiction()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('jurisdiction.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_jurisdiction()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('jurisdiction.create'));

        $response->assertRedirect('jurisdiction');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_jurisdiction()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('jurisdiction.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_jurisdiction()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('jurisdiction.show', ['id' => 1]));

        $response->assertRedirect('jurisdiction');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_jurisdiction()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('jurisdiction.edit', ['id' => 1]));

        $response->assertRedirect('jurisdiction');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_jurisdiction()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('jurisdiction.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_jurisdiction()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('jurisdiction.destroy', ['id' => 1]));

        $response->assertRedirect('jurisdiction');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_jurisdiction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('jurisdiction.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Jurisdiction to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_jurisdiction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('jurisdiction.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Jurisdiction to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_jurisdiction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('jurisdiction.create'));

        $response->assertStatus(200);
        $response->assertViewIs('jurisdiction.create');
        $response->assertSee('jurisdiction-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_jurisdiction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'jurisdiction_type_id' => "",
            'name' => "",
            'url' => "",
        ];

        $totalNumberOfJurisdictionsBefore = Jurisdiction::count();

        $response = $this->actingAs($user)->post(route('jurisdiction.store'), $data);

        $totalNumberOfJurisdictionsAfter = Jurisdiction::count();
        $this->assertEquals($totalNumberOfJurisdictionsAfter, $totalNumberOfJurisdictionsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_jurisdiction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'jurisdiction_type_id' => "a",
            'name' => "a",
            'url' => "a",
        ];

        $totalNumberOfJurisdictionsBefore = Jurisdiction::count();

        $response = $this->actingAs($user)->post(route('jurisdiction.store'), $data);

        $totalNumberOfJurisdictionsAfter = Jurisdiction::count();
        $this->assertEquals($totalNumberOfJurisdictionsAfter, $totalNumberOfJurisdictionsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_jurisdiction()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'jurisdiction_type_id' => "",
          'name' => $faker->name,
          'url' => "",
        ];

        info('--  Jurisdiction  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfJurisdictionsBefore = Jurisdiction::count();

        $response = $this->actingAs($user)->post(route('jurisdiction.store'), $data);

        $totalNumberOfJurisdictionsAfter = Jurisdiction::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfJurisdictionsAfter, $totalNumberOfJurisdictionsBefore + 1, "the number of total jurisdiction is supposed to be one more ");

        $lastInsertedInTheDB = Jurisdiction::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->jurisdiction_type_id, $data['jurisdiction_type_id'], "the jurisdiction_type_id of the saved jurisdiction is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved jurisdiction is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->url, $data['url'], "the url of the saved jurisdiction is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_jurisdiction()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfJurisdictionsBefore = Jurisdiction::count();

        $jurisdiction = Jurisdiction::get()->random();
        $data = [
            'id' => "",
            'jurisdiction_type_id' => "",
            'name' => $jurisdiction->name,
            'url' => "",
        ];

        $response = $this->actingAs($user)->post(route('jurisdiction.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfJurisdictionsAfter = Jurisdiction::count();
        $this->assertEquals($totalNumberOfJurisdictionsAfter, $totalNumberOfJurisdictionsBefore, "the number of total jurisdiction should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_jurisdiction()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Jurisdiction::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfJurisdictionsBefore = Jurisdiction::count();

        $response = $this->actingAs($user)->json('PATCH', 'jurisdiction/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfJurisdictionsAfter = Jurisdiction::count();
        $this->assertEquals($totalNumberOfJurisdictionsAfter, $totalNumberOfJurisdictionsBefore, "the number of total jurisdiction should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_jurisdiction()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Jurisdiction::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one jurisdiction record
        $jurisdiction_dup = [

            'jurisdiction_type_id' => "",
            'name' => $faker->name,
            'url' => "",
        ];

        $response = $this->actingAs($user)->post(route('jurisdiction.store'), $jurisdiction_dup);


        $data['name'] = $jurisdiction_dup['name'];

        $totalNumberOfJurisdictionsBefore = Jurisdiction::count();

        $response = $this->actingAs($user)->json('PATCH', 'jurisdiction/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfJurisdictionsAfter = Jurisdiction::count();
        $this->assertEquals($totalNumberOfJurisdictionsAfter, $totalNumberOfJurisdictionsBefore, "the number of total jurisdiction should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_jurisdiction()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Jurisdiction::get()->random()->toArray();


        $totalNumberOfJurisdictionsBefore = Jurisdiction::count();

        $response = $this->actingAs($user)->json('DELETE', 'jurisdiction/' . $data['id'], $data);

        $totalNumberOfJurisdictionsAfter = Jurisdiction::count();
        $this->assertEquals($totalNumberOfJurisdictionsAfter, $totalNumberOfJurisdictionsBefore - 1, "the number of total jurisdiction should be the same ");

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
