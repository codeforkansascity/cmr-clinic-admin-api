<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Charge;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class ChargeControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class ChargeControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_charge_index()
    {
        $response = $this->get('/charge');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_charge()
    {
        $response = $this->get(route('charge.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_charge()
    {
        $response = $this->get(route('charge.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_charge()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('charge.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_charge()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('charge.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_charge()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('charge.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_charge()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('charge.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_charge_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/charge');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_charge()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('charge.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_charge()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('charge.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_charge()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('charge.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_charge()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('charge.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_charge()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('charge.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_charge()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('charge.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_charge()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('charge.create'));

        $response->assertRedirect('charge');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_charge()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('charge.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_charge()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('charge.show', ['id' => 1]));

        $response->assertRedirect('charge');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_charge()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('charge.edit', ['id' => 1]));

        $response->assertRedirect('charge');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_charge()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('charge.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_charge()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('charge.destroy', ['id' => 1]));

        $response->assertRedirect('charge');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_charge()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('charge.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Charges to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_charge()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('charge.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Charges to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_charge()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('charge.create'));

        $response->assertStatus(200);
        $response->assertViewIs('charge.create');
        $response->assertSee('charge-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_charge()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'notes' => "",
        ];

        $totalNumberOfChargesBefore = Charge::count();

        $response = $this->actingAs($user)->post(route('charge.store'), $data);

        $totalNumberOfChargesAfter = Charge::count();
        $this->assertEquals($totalNumberOfChargesAfter, $totalNumberOfChargesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_charge()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'notes' => "a",
        ];

        $totalNumberOfChargesBefore = Charge::count();

        $response = $this->actingAs($user)->post(route('charge.store'), $data);

        $totalNumberOfChargesAfter = Charge::count();
        $this->assertEquals($totalNumberOfChargesAfter, $totalNumberOfChargesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_charge()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'notes' => "",
        ];

        info('--  Charge  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfChargesBefore = Charge::count();

        $response = $this->actingAs($user)->post(route('charge.store'), $data);

        $totalNumberOfChargesAfter = Charge::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfChargesAfter, $totalNumberOfChargesBefore + 1, "the number of total charge is supposed to be one more ");

        $lastInsertedInTheDB = Charge::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->notes, $data['notes'], "the notes of the saved charge is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_charge()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfChargesBefore = Charge::count();

        $charge = Charge::get()->random();
        $data = [
            'id' => "",
            'notes' => "",
        ];

        $response = $this->actingAs($user)->post(route('charge.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfChargesAfter = Charge::count();
        $this->assertEquals($totalNumberOfChargesAfter, $totalNumberOfChargesBefore, "the number of total charge should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_charge()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Charge::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfChargesBefore = Charge::count();

        $response = $this->actingAs($user)->json('PATCH', 'charge/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfChargesAfter = Charge::count();
        $this->assertEquals($totalNumberOfChargesAfter, $totalNumberOfChargesBefore, "the number of total charge should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_charge()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Charge::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one charge record
        $charge_dup = [

            'notes' => "",
        ];

        $response = $this->actingAs($user)->post(route('charge.store'), $charge_dup);


        $data['name'] = $charge_dup['name'];

        $totalNumberOfChargesBefore = Charge::count();

        $response = $this->actingAs($user)->json('PATCH', 'charge/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfChargesAfter = Charge::count();
        $this->assertEquals($totalNumberOfChargesAfter, $totalNumberOfChargesBefore, "the number of total charge should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_charge()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Charge::get()->random()->toArray();


        $totalNumberOfChargesBefore = Charge::count();

        $response = $this->actingAs($user)->json('DELETE', 'charge/' . $data['id'], $data);

        $totalNumberOfChargesAfter = Charge::count();
        $this->assertEquals($totalNumberOfChargesAfter, $totalNumberOfChargesBefore - 1, "the number of total charge should be the same ");

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
