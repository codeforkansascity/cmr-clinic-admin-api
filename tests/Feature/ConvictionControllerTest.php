<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Conviction;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class ConvictionControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class ConvictionControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_conviction_index()
    {
        $response = $this->get('/conviction');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_conviction()
    {
        $response = $this->get(route('conviction.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_conviction()
    {
        $response = $this->get(route('conviction.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_conviction()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('conviction.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_conviction()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('conviction.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_conviction()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('conviction.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_conviction()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('conviction.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_conviction_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/conviction');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_conviction()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('conviction.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_conviction()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('conviction.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_conviction()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('conviction.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_conviction()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('conviction.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_conviction()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('conviction.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_conviction()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('conviction.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_conviction()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('conviction.create'));

        $response->assertRedirect('conviction');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_conviction()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('conviction.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_conviction()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('conviction.show', ['id' => 1]));

        $response->assertRedirect('conviction');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_conviction()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('conviction.edit', ['id' => 1]));

        $response->assertRedirect('conviction');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_conviction()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('conviction.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_conviction()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('conviction.destroy', ['id' => 1]));

        $response->assertRedirect('conviction');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_conviction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('conviction.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Case to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_conviction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('conviction.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Case to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_conviction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('conviction.create'));

        $response->assertStatus(200);
        $response->assertViewIs('conviction.create');
        $response->assertSee('conviction-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_conviction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "",
            'notes' => "",
        ];

        $totalNumberOfConvictionsBefore = Conviction::count();

        $response = $this->actingAs($user)->post(route('conviction.store'), $data);

        $totalNumberOfConvictionsAfter = Conviction::count();
        $this->assertEquals($totalNumberOfConvictionsAfter, $totalNumberOfConvictionsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_conviction()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "a",
            'notes' => "a",
        ];

        $totalNumberOfConvictionsBefore = Conviction::count();

        $response = $this->actingAs($user)->post(route('conviction.store'), $data);

        $totalNumberOfConvictionsAfter = Conviction::count();
        $this->assertEquals($totalNumberOfConvictionsAfter, $totalNumberOfConvictionsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_conviction()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'name' => $faker->name,
          'notes' => "",
        ];

        info('--  Conviction  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfConvictionsBefore = Conviction::count();

        $response = $this->actingAs($user)->post(route('conviction.store'), $data);

        $totalNumberOfConvictionsAfter = Conviction::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfConvictionsAfter, $totalNumberOfConvictionsBefore + 1, "the number of total conviction is supposed to be one more ");

        $lastInsertedInTheDB = Conviction::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved conviction is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->notes, $data['notes'], "the notes of the saved conviction is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_conviction()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfConvictionsBefore = Conviction::count();

        $conviction = Conviction::get()->random();
        $data = [
            'id' => "",
            'name' => $conviction->name,
            'notes' => "",
        ];

        $response = $this->actingAs($user)->post(route('conviction.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfConvictionsAfter = Conviction::count();
        $this->assertEquals($totalNumberOfConvictionsAfter, $totalNumberOfConvictionsBefore, "the number of total conviction should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_conviction()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Conviction::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfConvictionsBefore = Conviction::count();

        $response = $this->actingAs($user)->json('PATCH', 'conviction/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfConvictionsAfter = Conviction::count();
        $this->assertEquals($totalNumberOfConvictionsAfter, $totalNumberOfConvictionsBefore, "the number of total conviction should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_conviction()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Conviction::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one conviction record
        $conviction_dup = [

            'name' => $faker->name,
            'notes' => "",
        ];

        $response = $this->actingAs($user)->post(route('conviction.store'), $conviction_dup);


        $data['name'] = $conviction_dup['name'];

        $totalNumberOfConvictionsBefore = Conviction::count();

        $response = $this->actingAs($user)->json('PATCH', 'conviction/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfConvictionsAfter = Conviction::count();
        $this->assertEquals($totalNumberOfConvictionsAfter, $totalNumberOfConvictionsBefore, "the number of total conviction should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_conviction()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Conviction::get()->random()->toArray();


        $totalNumberOfConvictionsBefore = Conviction::count();

        $response = $this->actingAs($user)->json('DELETE', 'conviction/' . $data['id'], $data);

        $totalNumberOfConvictionsAfter = Conviction::count();
        $this->assertEquals($totalNumberOfConvictionsAfter, $totalNumberOfConvictionsBefore - 1, "the number of total conviction should be the same ");

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
