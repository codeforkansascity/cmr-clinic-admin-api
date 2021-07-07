<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\LawVersion;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class LawVersionControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class LawVersionControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_law_version_index()
    {
        $response = $this->get('/law-version');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_law_version()
    {
        $response = $this->get(route('law-version.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_law_version()
    {
        $response = $this->get(route('law-version.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_law_version()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('law-version.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_law_version()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('law-version.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_law_version()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('law-version.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_law_version()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('law-version.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_law_version_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/law-version');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_law_version()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('law-version.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_law_version()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('law-version.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_law_version()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('law-version.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_law_version()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('law-version.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_law_version()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('law-version.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_law_version()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('law-version.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_law_version()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('law-version.create'));

        $response->assertRedirect('law-version');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_law_version()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('law-version.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_law_version()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('law-version.show', ['id' => 1]));

        $response->assertRedirect('law-version');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_law_version()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('law-version.edit', ['id' => 1]));

        $response->assertRedirect('law-version');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_law_version()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('law-version.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_law_version()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('law-version.destroy', ['id' => 1]));

        $response->assertRedirect('law-version');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_law_version()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('law-version.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Law Versions to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_law_version()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('law-version.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Law Versions to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_law_version()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('law-version.create'));

        $response->assertStatus(200);
        $response->assertViewIs('law-version.create');
        $response->assertSee('law-version-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_law_version()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'number' => "",
            'name' => "",
        ];

        $totalNumberOfLawVersionsBefore = LawVersion::count();

        $response = $this->actingAs($user)->post(route('law-version.store'), $data);

        $totalNumberOfLawVersionsAfter = LawVersion::count();
        $this->assertEquals($totalNumberOfLawVersionsAfter, $totalNumberOfLawVersionsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_law_version()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'number' => "a",
            'name' => "a",
        ];

        $totalNumberOfLawVersionsBefore = LawVersion::count();

        $response = $this->actingAs($user)->post(route('law-version.store'), $data);

        $totalNumberOfLawVersionsAfter = LawVersion::count();
        $this->assertEquals($totalNumberOfLawVersionsAfter, $totalNumberOfLawVersionsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_law_version()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'number' => "",
          'name' => $faker->name,
        ];

        info('--  LawVersion  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfLawVersionsBefore = LawVersion::count();

        $response = $this->actingAs($user)->post(route('law-version.store'), $data);

        $totalNumberOfLawVersionsAfter = LawVersion::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfLawVersionsAfter, $totalNumberOfLawVersionsBefore + 1, "the number of total law_version is supposed to be one more ");

        $lastInsertedInTheDB = LawVersion::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->number, $data['number'], "the number of the saved law_version is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved law_version is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_law_version()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfLawVersionsBefore = LawVersion::count();

        $law_version = LawVersion::get()->random();
        $data = [
            'id' => "",
            'number' => "",
            'name' => $law_version->name,
        ];

        $response = $this->actingAs($user)->post(route('law-version.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfLawVersionsAfter = LawVersion::count();
        $this->assertEquals($totalNumberOfLawVersionsAfter, $totalNumberOfLawVersionsBefore, "the number of total law_version should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_law_version()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = LawVersion::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfLawVersionsBefore = LawVersion::count();

        $response = $this->actingAs($user)->json('PATCH', 'law-version/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfLawVersionsAfter = LawVersion::count();
        $this->assertEquals($totalNumberOfLawVersionsAfter, $totalNumberOfLawVersionsBefore, "the number of total law_version should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_law_version()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = LawVersion::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one law_version record
        $law_version_dup = [

            'number' => "",
            'name' => $faker->name,
        ];

        $response = $this->actingAs($user)->post(route('law-version.store'), $law_version_dup);


        $data['name'] = $law_version_dup['name'];

        $totalNumberOfLawVersionsBefore = LawVersion::count();

        $response = $this->actingAs($user)->json('PATCH', 'law-version/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfLawVersionsAfter = LawVersion::count();
        $this->assertEquals($totalNumberOfLawVersionsAfter, $totalNumberOfLawVersionsBefore, "the number of total law_version should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_law_version()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = LawVersion::get()->random()->toArray();


        $totalNumberOfLawVersionsBefore = LawVersion::count();

        $response = $this->actingAs($user)->json('DELETE', 'law-version/' . $data['id'], $data);

        $totalNumberOfLawVersionsAfter = LawVersion::count();
        $this->assertEquals($totalNumberOfLawVersionsAfter, $totalNumberOfLawVersionsBefore - 1, "the number of total law_version should be the same ");

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
