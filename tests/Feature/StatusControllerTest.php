<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Status;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class StatusControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class StatusControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_status_index()
    {
        $response = $this->get('/status');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_status()
    {
        $response = $this->get(route('status.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_status()
    {
        $response = $this->get(route('status.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_status()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('status.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_status()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('status.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_status()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('status.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_status()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('status.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_status_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/status');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_status()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('status.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_status()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('status.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_status()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('status.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_status()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('status.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_status()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('status.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_status()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('status.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_status()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('status.create'));

        $response->assertRedirect('status');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_status()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('status.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_status()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('status.show', ['id' => 1]));

        $response->assertRedirect('status');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_status()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('status.edit', ['id' => 1]));

        $response->assertRedirect('status');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_status()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('status.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_status()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('status.destroy', ['id' => 1]));

        $response->assertRedirect('status');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_status()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('status.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Status to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_status()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('status.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Status to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_status()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('status.create'));

        $response->assertStatus(200);
        $response->assertViewIs('status.create');
        $response->assertSee('status-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_status()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "",
            'alias' => "",
            'sequence' => "",
        ];

        $totalNumberOfStatusesBefore = Status::count();

        $response = $this->actingAs($user)->post(route('status.store'), $data);

        $totalNumberOfStatusesAfter = Status::count();
        $this->assertEquals($totalNumberOfStatusesAfter, $totalNumberOfStatusesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_status()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "a",
            'alias' => "a",
            'sequence' => "a",
        ];

        $totalNumberOfStatusesBefore = Status::count();

        $response = $this->actingAs($user)->post(route('status.store'), $data);

        $totalNumberOfStatusesAfter = Status::count();
        $this->assertEquals($totalNumberOfStatusesAfter, $totalNumberOfStatusesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_status()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'name' => $faker->name,
          'alias' => "",
          'sequence' => "",
        ];

        info('--  Status  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfStatusesBefore = Status::count();

        $response = $this->actingAs($user)->post(route('status.store'), $data);

        $totalNumberOfStatusesAfter = Status::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfStatusesAfter, $totalNumberOfStatusesBefore + 1, "the number of total status is supposed to be one more ");

        $lastInsertedInTheDB = Status::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved status is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->alias, $data['alias'], "the alias of the saved status is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->sequence, $data['sequence'], "the sequence of the saved status is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_status()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfStatusesBefore = Status::count();

        $status = Status::get()->random();
        $data = [
            'id' => "",
            'name' => $status->name,
            'alias' => "",
            'sequence' => "",
        ];

        $response = $this->actingAs($user)->post(route('status.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfStatusesAfter = Status::count();
        $this->assertEquals($totalNumberOfStatusesAfter, $totalNumberOfStatusesBefore, "the number of total status should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_status()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Status::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfStatusesBefore = Status::count();

        $response = $this->actingAs($user)->json('PATCH', 'status/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfStatusesAfter = Status::count();
        $this->assertEquals($totalNumberOfStatusesAfter, $totalNumberOfStatusesBefore, "the number of total status should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_status()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Status::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one status record
        $status_dup = [

            'name' => $faker->name,
            'alias' => "",
            'sequence' => "",
        ];

        $response = $this->actingAs($user)->post(route('status.store'), $status_dup);


        $data['name'] = $status_dup['name'];

        $totalNumberOfStatusesBefore = Status::count();

        $response = $this->actingAs($user)->json('PATCH', 'status/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfStatusesAfter = Status::count();
        $this->assertEquals($totalNumberOfStatusesAfter, $totalNumberOfStatusesBefore, "the number of total status should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_status()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Status::get()->random()->toArray();


        $totalNumberOfStatusesBefore = Status::count();

        $response = $this->actingAs($user)->json('DELETE', 'status/' . $data['id'], $data);

        $totalNumberOfStatusesAfter = Status::count();
        $this->assertEquals($totalNumberOfStatusesAfter, $totalNumberOfStatusesBefore - 1, "the number of total status should be the same ");

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
