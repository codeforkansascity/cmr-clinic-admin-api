<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Law;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class LawControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class LawControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_law_index()
    {
        $response = $this->get('/law');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_law()
    {
        $response = $this->get(route('law.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_law()
    {
        $response = $this->get(route('law.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_law()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('law.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_law()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('law.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_law()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('law.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_law()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('law.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_law_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/law');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_law()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('law.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_law()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('law.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_law()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('law.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_law()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('law.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_law()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('law.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_law()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('law.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_law()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('law.create'));

        $response->assertRedirect('law');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_law()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('law.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_law()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('law.show', ['id' => 1]));

        $response->assertRedirect('law');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_law()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('law.edit', ['id' => 1]));

        $response->assertRedirect('law');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_law()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('law.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_law()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('law.destroy', ['id' => 1]));

        $response->assertRedirect('law');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_law()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('law.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Laws to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_law()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('law.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Laws to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_law()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('law.create'));

        $response->assertStatus(200);
        $response->assertViewIs('law.create');
        $response->assertSee('law-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_law()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
        ];

        $totalNumberOfLawsBefore = Law::count();

        $response = $this->actingAs($user)->post(route('law.store'), $data);

        $totalNumberOfLawsAfter = Law::count();
        $this->assertEquals($totalNumberOfLawsAfter, $totalNumberOfLawsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_law()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
        ];

        $totalNumberOfLawsBefore = Law::count();

        $response = $this->actingAs($user)->post(route('law.store'), $data);

        $totalNumberOfLawsAfter = Law::count();
        $this->assertEquals($totalNumberOfLawsAfter, $totalNumberOfLawsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_law()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
        ];

        info('--  Law  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfLawsBefore = Law::count();

        $response = $this->actingAs($user)->post(route('law.store'), $data);

        $totalNumberOfLawsAfter = Law::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfLawsAfter, $totalNumberOfLawsBefore + 1, "the number of total law is supposed to be one more ");

        $lastInsertedInTheDB = Law::orderBy('id', 'desc')->first();


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_law()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfLawsBefore = Law::count();

        $law = Law::get()->random();
        $data = [
            'id' => "",
        ];

        $response = $this->actingAs($user)->post(route('law.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfLawsAfter = Law::count();
        $this->assertEquals($totalNumberOfLawsAfter, $totalNumberOfLawsBefore, "the number of total law should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_law()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Law::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfLawsBefore = Law::count();

        $response = $this->actingAs($user)->json('PATCH', 'law/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfLawsAfter = Law::count();
        $this->assertEquals($totalNumberOfLawsAfter, $totalNumberOfLawsBefore, "the number of total law should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_law()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Law::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one law record
        $law_dup = [

        ];

        $response = $this->actingAs($user)->post(route('law.store'), $law_dup);


        $data['name'] = $law_dup['name'];

        $totalNumberOfLawsBefore = Law::count();

        $response = $this->actingAs($user)->json('PATCH', 'law/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfLawsAfter = Law::count();
        $this->assertEquals($totalNumberOfLawsAfter, $totalNumberOfLawsBefore, "the number of total law should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_law()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Law::get()->random()->toArray();


        $totalNumberOfLawsBefore = Law::count();

        $response = $this->actingAs($user)->json('DELETE', 'law/' . $data['id'], $data);

        $totalNumberOfLawsAfter = Law::count();
        $this->assertEquals($totalNumberOfLawsAfter, $totalNumberOfLawsBefore - 1, "the number of total law should be the same ");

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
