<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Assignment;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class AssignmentControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class AssignmentControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_assignment_index()
    {
        $response = $this->get('/assignment');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_assignment()
    {
        $response = $this->get(route('assignment.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_assignment()
    {
        $response = $this->get(route('assignment.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_assignment()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('assignment.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_assignment()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('assignment.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_assignment()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('assignment.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_assignment()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('assignment.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_assignment_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/assignment');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_assignment()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('assignment.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_assignment()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('assignment.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_assignment()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('assignment.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_assignment()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('assignment.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_assignment()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('assignment.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_assignment()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('assignment.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_assignment()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('assignment.create'));

        $response->assertRedirect('assignment');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_assignment()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('assignment.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_assignment()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('assignment.show', ['id' => 1]));

        $response->assertRedirect('assignment');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_assignment()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('assignment.edit', ['id' => 1]));

        $response->assertRedirect('assignment');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_assignment()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('assignment.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_assignment()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('assignment.destroy', ['id' => 1]));

        $response->assertRedirect('assignment');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_assignment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('assignment.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Assignment to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_assignment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('assignment.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Assignment to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_assignment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('assignment.create'));

        $response->assertStatus(200);
        $response->assertViewIs('assignment.create');
        $response->assertSee('assignment-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_assignment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "",
            'client_id' => "",
            'user_id' => "",
        ];

        $totalNumberOfAssignmentsBefore = Assignment::count();

        $response = $this->actingAs($user)->post(route('assignment.store'), $data);

        $totalNumberOfAssignmentsAfter = Assignment::count();
        $this->assertEquals($totalNumberOfAssignmentsAfter, $totalNumberOfAssignmentsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_assignment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "a",
            'client_id' => "a",
            'user_id' => "a",
        ];

        $totalNumberOfAssignmentsBefore = Assignment::count();

        $response = $this->actingAs($user)->post(route('assignment.store'), $data);

        $totalNumberOfAssignmentsAfter = Assignment::count();
        $this->assertEquals($totalNumberOfAssignmentsAfter, $totalNumberOfAssignmentsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_assignment()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'name' => $faker->name,
          'client_id' => "",
          'user_id' => "",
        ];

        info('--  Assignment  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfAssignmentsBefore = Assignment::count();

        $response = $this->actingAs($user)->post(route('assignment.store'), $data);

        $totalNumberOfAssignmentsAfter = Assignment::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfAssignmentsAfter, $totalNumberOfAssignmentsBefore + 1, "the number of total assignment is supposed to be one more ");

        $lastInsertedInTheDB = Assignment::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved assignment is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->client_id, $data['client_id'], "the client_id of the saved assignment is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->user_id, $data['user_id'], "the user_id of the saved assignment is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_assignment()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfAssignmentsBefore = Assignment::count();

        $assignment = Assignment::get()->random();
        $data = [
            'id' => "",
            'name' => $assignment->name,
            'client_id' => "",
            'user_id' => "",
        ];

        $response = $this->actingAs($user)->post(route('assignment.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfAssignmentsAfter = Assignment::count();
        $this->assertEquals($totalNumberOfAssignmentsAfter, $totalNumberOfAssignmentsBefore, "the number of total assignment should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_assignment()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Assignment::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfAssignmentsBefore = Assignment::count();

        $response = $this->actingAs($user)->json('PATCH', 'assignment/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfAssignmentsAfter = Assignment::count();
        $this->assertEquals($totalNumberOfAssignmentsAfter, $totalNumberOfAssignmentsBefore, "the number of total assignment should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_assignment()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Assignment::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one assignment record
        $assignment_dup = [

            'name' => $faker->name,
            'client_id' => "",
            'user_id' => "",
        ];

        $response = $this->actingAs($user)->post(route('assignment.store'), $assignment_dup);


        $data['name'] = $assignment_dup['name'];

        $totalNumberOfAssignmentsBefore = Assignment::count();

        $response = $this->actingAs($user)->json('PATCH', 'assignment/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfAssignmentsAfter = Assignment::count();
        $this->assertEquals($totalNumberOfAssignmentsAfter, $totalNumberOfAssignmentsBefore, "the number of total assignment should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_assignment()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Assignment::get()->random()->toArray();


        $totalNumberOfAssignmentsBefore = Assignment::count();

        $response = $this->actingAs($user)->json('DELETE', 'assignment/' . $data['id'], $data);

        $totalNumberOfAssignmentsAfter = Assignment::count();
        $this->assertEquals($totalNumberOfAssignmentsAfter, $totalNumberOfAssignmentsBefore - 1, "the number of total assignment should be the same ");

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
