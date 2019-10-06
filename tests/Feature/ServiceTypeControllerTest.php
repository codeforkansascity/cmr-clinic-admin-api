<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\ServiceType;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class ServiceTypeControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class ServiceTypeControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_service_type_index()
    {
        $response = $this->get('/service-type');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_service_type()
    {
        $response = $this->get(route('service-type.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_service_type()
    {
        $response = $this->get(route('service-type.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_service_type()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('service-type.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_service_type()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('service-type.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_service_type()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('service-type.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_service_type()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('service-type.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_service_type_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/service-type');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_service_type()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('service-type.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_service_type()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('service-type.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_service_type()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('service-type.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_service_type()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('service-type.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_service_type()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('service-type.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_service_type()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('service-type.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_service_type()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('service-type.create'));

        $response->assertRedirect('service-type');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_service_type()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('service-type.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_service_type()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('service-type.show', ['id' => 1]));

        $response->assertRedirect('service-type');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_service_type()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('service-type.edit', ['id' => 1]));

        $response->assertRedirect('service-type');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_service_type()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('service-type.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_service_type()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('service-type.destroy', ['id' => 1]));

        $response->assertRedirect('service-type');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_service_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('service-type.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Service Types to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_service_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('service-type.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Service Types to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_service_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('service-type.create'));

        $response->assertStatus(200);
        $response->assertViewIs('service-type.create');
        $response->assertSee('service-type-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_service_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "",
        ];

        $totalNumberOfServiceTypesBefore = ServiceType::count();

        $response = $this->actingAs($user)->post(route('service-type.store'), $data);

        $totalNumberOfServiceTypesAfter = ServiceType::count();
        $this->assertEquals($totalNumberOfServiceTypesAfter, $totalNumberOfServiceTypesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_service_type()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "a",
        ];

        $totalNumberOfServiceTypesBefore = ServiceType::count();

        $response = $this->actingAs($user)->post(route('service-type.store'), $data);

        $totalNumberOfServiceTypesAfter = ServiceType::count();
        $this->assertEquals($totalNumberOfServiceTypesAfter, $totalNumberOfServiceTypesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_service_type()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'name' => $faker->name,
        ];

        info('--  ServiceType  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfServiceTypesBefore = ServiceType::count();

        $response = $this->actingAs($user)->post(route('service-type.store'), $data);

        $totalNumberOfServiceTypesAfter = ServiceType::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfServiceTypesAfter, $totalNumberOfServiceTypesBefore + 1, "the number of total service_type is supposed to be one more ");

        $lastInsertedInTheDB = ServiceType::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved service_type is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_service_type()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfServiceTypesBefore = ServiceType::count();

        $service_type = ServiceType::get()->random();
        $data = [
            'id' => "",
            'name' => $service_type->name,
        ];

        $response = $this->actingAs($user)->post(route('service-type.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfServiceTypesAfter = ServiceType::count();
        $this->assertEquals($totalNumberOfServiceTypesAfter, $totalNumberOfServiceTypesBefore, "the number of total service_type should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_service_type()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = ServiceType::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfServiceTypesBefore = ServiceType::count();

        $response = $this->actingAs($user)->json('PATCH', 'service-type/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfServiceTypesAfter = ServiceType::count();
        $this->assertEquals($totalNumberOfServiceTypesAfter, $totalNumberOfServiceTypesBefore, "the number of total service_type should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_service_type()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = ServiceType::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one service_type record
        $service_type_dup = [

            'name' => $faker->name,
        ];

        $response = $this->actingAs($user)->post(route('service-type.store'), $service_type_dup);


        $data['name'] = $service_type_dup['name'];

        $totalNumberOfServiceTypesBefore = ServiceType::count();

        $response = $this->actingAs($user)->json('PATCH', 'service-type/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfServiceTypesAfter = ServiceType::count();
        $this->assertEquals($totalNumberOfServiceTypesAfter, $totalNumberOfServiceTypesBefore, "the number of total service_type should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_service_type()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = ServiceType::get()->random()->toArray();


        $totalNumberOfServiceTypesBefore = ServiceType::count();

        $response = $this->actingAs($user)->json('DELETE', 'service-type/' . $data['id'], $data);

        $totalNumberOfServiceTypesAfter = ServiceType::count();
        $this->assertEquals($totalNumberOfServiceTypesAfter, $totalNumberOfServiceTypesBefore - 1, "the number of total service_type should be the same ");

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
