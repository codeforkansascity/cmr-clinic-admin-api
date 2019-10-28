<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Statute;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class StatuteControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class StatuteControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_statute_index()
    {
        $response = $this->get('/statute');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_statute()
    {
        $response = $this->get(route('statute.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_statute()
    {
        $response = $this->get(route('statute.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_statute()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('statute.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_statute()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('statute.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_statute()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('statute.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_statute()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('statute.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_statute_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/statute');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_statute()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('statute.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_statute()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('statute.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_statute()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('statute.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_statute()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('statute.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_statute()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('statute.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_statute()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('statute.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_statute()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('statute.create'));

        $response->assertRedirect('statute');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_statute()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('statute.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_statute()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('statute.show', ['id' => 1]));

        $response->assertRedirect('statute');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_statute()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('statute.edit', ['id' => 1]));

        $response->assertRedirect('statute');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_statute()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('statute.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_statute()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('statute.destroy', ['id' => 1]));

        $response->assertRedirect('statute');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_statute()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('statute.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Statutes to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_statute()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('statute.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Statutes to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_statute()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('statute.create'));

        $response->assertStatus(200);
        $response->assertViewIs('statute.create');
        $response->assertSee('statute-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_statute()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'number' => "",
            'name' => "",
            'eligible' => "",
        ];

        $totalNumberOfStatutesBefore = Statute::count();

        $response = $this->actingAs($user)->post(route('statute.store'), $data);

        $totalNumberOfStatutesAfter = Statute::count();
        $this->assertEquals($totalNumberOfStatutesAfter, $totalNumberOfStatutesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_statute()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'number' => "a",
            'name' => "a",
            'eligible' => "a",
        ];

        $totalNumberOfStatutesBefore = Statute::count();

        $response = $this->actingAs($user)->post(route('statute.store'), $data);

        $totalNumberOfStatutesAfter = Statute::count();
        $this->assertEquals($totalNumberOfStatutesAfter, $totalNumberOfStatutesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_statute()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'number' => "",
          'name' => $faker->name,
          'eligible' => "",
        ];

        info('--  Statute  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfStatutesBefore = Statute::count();

        $response = $this->actingAs($user)->post(route('statute.store'), $data);

        $totalNumberOfStatutesAfter = Statute::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfStatutesAfter, $totalNumberOfStatutesBefore + 1, "the number of total statute is supposed to be one more ");

        $lastInsertedInTheDB = Statute::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->number, $data['number'], "the number of the saved statute is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved statute is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->eligible, $data['eligible'], "the eligible of the saved statute is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_statute()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfStatutesBefore = Statute::count();

        $statute = Statute::get()->random();
        $data = [
            'id' => "",
            'number' => "",
            'name' => $statute->name,
            'eligible' => "",
        ];

        $response = $this->actingAs($user)->post(route('statute.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfStatutesAfter = Statute::count();
        $this->assertEquals($totalNumberOfStatutesAfter, $totalNumberOfStatutesBefore, "the number of total statute should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_statute()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Statute::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfStatutesBefore = Statute::count();

        $response = $this->actingAs($user)->json('PATCH', 'statute/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfStatutesAfter = Statute::count();
        $this->assertEquals($totalNumberOfStatutesAfter, $totalNumberOfStatutesBefore, "the number of total statute should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_statute()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Statute::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one statute record
        $statute_dup = [

            'number' => "",
            'name' => $faker->name,
            'eligible' => "",
        ];

        $response = $this->actingAs($user)->post(route('statute.store'), $statute_dup);


        $data['name'] = $statute_dup['name'];

        $totalNumberOfStatutesBefore = Statute::count();

        $response = $this->actingAs($user)->json('PATCH', 'statute/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfStatutesAfter = Statute::count();
        $this->assertEquals($totalNumberOfStatutesAfter, $totalNumberOfStatutesBefore, "the number of total statute should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_statute()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Statute::get()->random()->toArray();


        $totalNumberOfStatutesBefore = Statute::count();

        $response = $this->actingAs($user)->json('DELETE', 'statute/' . $data['id'], $data);

        $totalNumberOfStatutesAfter = Statute::count();
        $this->assertEquals($totalNumberOfStatutesAfter, $totalNumberOfStatutesBefore - 1, "the number of total statute should be the same ");

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
