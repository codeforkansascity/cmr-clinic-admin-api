<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Exception;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class ExceptionControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class ExceptionControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_exception_index()
    {
        $response = $this->get('/exception');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_exception()
    {
        $response = $this->get(route('exception.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_exception()
    {
        $response = $this->get(route('exception.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_exception()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('exception.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_exception()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('exception.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_exception()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('exception.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_exception()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('exception.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_exception_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/exception');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_exception()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('exception.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_exception()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('exception.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_exception()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('exception.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_exception()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('exception.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_exception()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('exception.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_exception()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('exception.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_exception()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('exception.create'));

        $response->assertRedirect('exception');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_exception()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('exception.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_exception()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('exception.show', ['id' => 1]));

        $response->assertRedirect('exception');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_exception()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('exception.edit', ['id' => 1]));

        $response->assertRedirect('exception');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_exception()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('exception.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_exception()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('exception.destroy', ['id' => 1]));

        $response->assertRedirect('exception');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_exception()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('exception.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Exceptions to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_exception()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('exception.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Exceptions to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_exception()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('exception.create'));

        $response->assertStatus(200);
        $response->assertViewIs('exception.create');
        $response->assertSee('exception-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_exception()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'section' => "",
            'name' => "",
            'short_name' => "",
            'attorney_note' => "",
            'dyi_note' => "",
            'logic' => "",
        ];

        $totalNumberOfExceptionsBefore = Exception::count();

        $response = $this->actingAs($user)->post(route('exception.store'), $data);

        $totalNumberOfExceptionsAfter = Exception::count();
        $this->assertEquals($totalNumberOfExceptionsAfter, $totalNumberOfExceptionsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_exception()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'section' => "a",
            'name' => "a",
            'short_name' => "a",
            'attorney_note' => "a",
            'dyi_note' => "a",
            'logic' => "a",
        ];

        $totalNumberOfExceptionsBefore = Exception::count();

        $response = $this->actingAs($user)->post(route('exception.store'), $data);

        $totalNumberOfExceptionsAfter = Exception::count();
        $this->assertEquals($totalNumberOfExceptionsAfter, $totalNumberOfExceptionsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_exception()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'section' => "",
          'name' => $faker->name,
          'short_name' => "",
          'attorney_note' => "",
          'dyi_note' => "",
          'logic' => "",
        ];

        info('--  Exception  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfExceptionsBefore = Exception::count();

        $response = $this->actingAs($user)->post(route('exception.store'), $data);

        $totalNumberOfExceptionsAfter = Exception::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfExceptionsAfter, $totalNumberOfExceptionsBefore + 1, "the number of total exception is supposed to be one more ");

        $lastInsertedInTheDB = Exception::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->section, $data['section'], "the section of the saved exception is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved exception is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->short_name, $data['short_name'], "the short_name of the saved exception is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->attorney_note, $data['attorney_note'], "the attorney_note of the saved exception is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->dyi_note, $data['dyi_note'], "the dyi_note of the saved exception is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->logic, $data['logic'], "the logic of the saved exception is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_exception()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfExceptionsBefore = Exception::count();

        $exception = Exception::get()->random();
        $data = [
            'id' => "",
            'section' => "",
            'name' => $exception->name,
            'short_name' => "",
            'attorney_note' => "",
            'dyi_note' => "",
            'logic' => "",
        ];

        $response = $this->actingAs($user)->post(route('exception.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfExceptionsAfter = Exception::count();
        $this->assertEquals($totalNumberOfExceptionsAfter, $totalNumberOfExceptionsBefore, "the number of total exception should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_exception()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Exception::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfExceptionsBefore = Exception::count();

        $response = $this->actingAs($user)->json('PATCH', 'exception/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfExceptionsAfter = Exception::count();
        $this->assertEquals($totalNumberOfExceptionsAfter, $totalNumberOfExceptionsBefore, "the number of total exception should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_exception()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Exception::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one exception record
        $exception_dup = [

            'section' => "",
            'name' => $faker->name,
            'short_name' => "",
            'attorney_note' => "",
            'dyi_note' => "",
            'logic' => "",
        ];

        $response = $this->actingAs($user)->post(route('exception.store'), $exception_dup);


        $data['name'] = $exception_dup['name'];

        $totalNumberOfExceptionsBefore = Exception::count();

        $response = $this->actingAs($user)->json('PATCH', 'exception/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfExceptionsAfter = Exception::count();
        $this->assertEquals($totalNumberOfExceptionsAfter, $totalNumberOfExceptionsBefore, "the number of total exception should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_exception()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Exception::get()->random()->toArray();


        $totalNumberOfExceptionsBefore = Exception::count();

        $response = $this->actingAs($user)->json('DELETE', 'exception/' . $data['id'], $data);

        $totalNumberOfExceptionsAfter = Exception::count();
        $this->assertEquals($totalNumberOfExceptionsAfter, $totalNumberOfExceptionsBefore - 1, "the number of total exception should be the same ");

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
