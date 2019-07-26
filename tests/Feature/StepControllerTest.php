<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Step;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class StepControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class StepControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_step_index()
    {
        $response = $this->get('/step');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_step()
    {
        $response = $this->get(route('step.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_step()
    {
        $response = $this->get(route('step.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_step()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('step.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_step()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('step.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_step()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('step.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_step()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('step.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_step_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/step');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_step()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('step.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_step()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('step.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_step()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('step.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_step()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('step.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_step()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('step.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_step()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('step.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_step()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('step.create'));

        $response->assertRedirect('step');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_step()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('step.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_step()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('step.show', ['id' => 1]));

        $response->assertRedirect('step');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_step()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('step.edit', ['id' => 1]));

        $response->assertRedirect('step');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_step()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('step.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_step()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('step.destroy', ['id' => 1]));

        $response->assertRedirect('step');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_step()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('step.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Step to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_step()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('step.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Step to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_step()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('step.create'));

        $response->assertStatus(200);
        $response->assertViewIs('step.create');
        $response->assertSee('step-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_step()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "",
            'client_id' => "",
            'status_id' => "",
        ];

        $totalNumberOfStepsBefore = Step::count();

        $response = $this->actingAs($user)->post(route('step.store'), $data);

        $totalNumberOfStepsAfter = Step::count();
        $this->assertEquals($totalNumberOfStepsAfter, $totalNumberOfStepsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_step()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "a",
            'client_id' => "a",
            'status_id' => "a",
        ];

        $totalNumberOfStepsBefore = Step::count();

        $response = $this->actingAs($user)->post(route('step.store'), $data);

        $totalNumberOfStepsAfter = Step::count();
        $this->assertEquals($totalNumberOfStepsAfter, $totalNumberOfStepsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_step()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'name' => $faker->name,
          'client_id' => "",
          'status_id' => "",
        ];

        info('--  Step  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfStepsBefore = Step::count();

        $response = $this->actingAs($user)->post(route('step.store'), $data);

        $totalNumberOfStepsAfter = Step::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfStepsAfter, $totalNumberOfStepsBefore + 1, "the number of total step is supposed to be one more ");

        $lastInsertedInTheDB = Step::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved step is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->client_id, $data['client_id'], "the client_id of the saved step is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->status_id, $data['status_id'], "the status_id of the saved step is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_step()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfStepsBefore = Step::count();

        $step = Step::get()->random();
        $data = [
            'id' => "",
            'name' => $step->name,
            'client_id' => "",
            'status_id' => "",
        ];

        $response = $this->actingAs($user)->post(route('step.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfStepsAfter = Step::count();
        $this->assertEquals($totalNumberOfStepsAfter, $totalNumberOfStepsBefore, "the number of total step should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_step()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Step::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfStepsBefore = Step::count();

        $response = $this->actingAs($user)->json('PATCH', 'step/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfStepsAfter = Step::count();
        $this->assertEquals($totalNumberOfStepsAfter, $totalNumberOfStepsBefore, "the number of total step should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_step()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Step::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one step record
        $step_dup = [

            'name' => $faker->name,
            'client_id' => "",
            'status_id' => "",
        ];

        $response = $this->actingAs($user)->post(route('step.store'), $step_dup);


        $data['name'] = $step_dup['name'];

        $totalNumberOfStepsBefore = Step::count();

        $response = $this->actingAs($user)->json('PATCH', 'step/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfStepsAfter = Step::count();
        $this->assertEquals($totalNumberOfStepsAfter, $totalNumberOfStepsBefore, "the number of total step should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_step()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Step::get()->random()->toArray();


        $totalNumberOfStepsBefore = Step::count();

        $response = $this->actingAs($user)->json('DELETE', 'step/' . $data['id'], $data);

        $totalNumberOfStepsAfter = Step::count();
        $this->assertEquals($totalNumberOfStepsAfter, $totalNumberOfStepsBefore - 1, "the number of total step should be the same ");

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
