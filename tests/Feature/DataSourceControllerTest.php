<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\DataSource;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class DataSourceControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class DataSourceControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_data_source_index()
    {
        $response = $this->get('/data-source');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_data_source()
    {
        $response = $this->get(route('data-source.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_data_source()
    {
        $response = $this->get(route('data-source.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_data_source()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('data-source.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_data_source()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('data-source.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_data_source()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('data-source.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_data_source()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('data-source.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_data_source_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/data-source');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_data_source()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('data-source.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_data_source()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('data-source.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_data_source()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('data-source.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_data_source()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('data-source.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_data_source()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('data-source.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_data_source()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('data-source.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_data_source()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('data-source.create'));

        $response->assertRedirect('data-source');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_data_source()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('data-source.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_data_source()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('data-source.show', ['id' => 1]));

        $response->assertRedirect('data-source');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_data_source()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('data-source.edit', ['id' => 1]));

        $response->assertRedirect('data-source');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_data_source()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('data-source.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_data_source()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('data-source.destroy', ['id' => 1]));

        $response->assertRedirect('data-source');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_data_source()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('data-source.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Sources to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_data_source()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('data-source.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Sources to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_data_source()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('data-source.create'));

        $response->assertStatus(200);
        $response->assertViewIs('data-source.create');
        $response->assertSee('data-source-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_data_source()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "",
            'description' => "",
        ];

        $totalNumberOfDataSourcesBefore = DataSource::count();

        $response = $this->actingAs($user)->post(route('data-source.store'), $data);

        $totalNumberOfDataSourcesAfter = DataSource::count();
        $this->assertEquals($totalNumberOfDataSourcesAfter, $totalNumberOfDataSourcesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_data_source()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "a",
            'description' => "a",
        ];

        $totalNumberOfDataSourcesBefore = DataSource::count();

        $response = $this->actingAs($user)->post(route('data-source.store'), $data);

        $totalNumberOfDataSourcesAfter = DataSource::count();
        $this->assertEquals($totalNumberOfDataSourcesAfter, $totalNumberOfDataSourcesBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_data_source()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'name' => $faker->name,
          'description' => "",
        ];

        info('--  DataSource  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfDataSourcesBefore = DataSource::count();

        $response = $this->actingAs($user)->post(route('data-source.store'), $data);

        $totalNumberOfDataSourcesAfter = DataSource::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfDataSourcesAfter, $totalNumberOfDataSourcesBefore + 1, "the number of total data_source is supposed to be one more ");

        $lastInsertedInTheDB = DataSource::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved data_source is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->description, $data['description'], "the description of the saved data_source is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_data_source()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfDataSourcesBefore = DataSource::count();

        $data_source = DataSource::get()->random();
        $data = [
            'id' => "",
            'name' => $data_source->name,
            'description' => "",
        ];

        $response = $this->actingAs($user)->post(route('data-source.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfDataSourcesAfter = DataSource::count();
        $this->assertEquals($totalNumberOfDataSourcesAfter, $totalNumberOfDataSourcesBefore, "the number of total data_source should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_data_source()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = DataSource::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfDataSourcesBefore = DataSource::count();

        $response = $this->actingAs($user)->json('PATCH', 'data-source/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfDataSourcesAfter = DataSource::count();
        $this->assertEquals($totalNumberOfDataSourcesAfter, $totalNumberOfDataSourcesBefore, "the number of total data_source should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_data_source()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = DataSource::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one data_source record
        $data_source_dup = [

            'name' => $faker->name,
            'description' => "",
        ];

        $response = $this->actingAs($user)->post(route('data-source.store'), $data_source_dup);


        $data['name'] = $data_source_dup['name'];

        $totalNumberOfDataSourcesBefore = DataSource::count();

        $response = $this->actingAs($user)->json('PATCH', 'data-source/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfDataSourcesAfter = DataSource::count();
        $this->assertEquals($totalNumberOfDataSourcesAfter, $totalNumberOfDataSourcesBefore, "the number of total data_source should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_data_source()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = DataSource::get()->random()->toArray();


        $totalNumberOfDataSourcesBefore = DataSource::count();

        $response = $this->actingAs($user)->json('DELETE', 'data-source/' . $data['id'], $data);

        $totalNumberOfDataSourcesAfter = DataSource::count();
        $this->assertEquals($totalNumberOfDataSourcesAfter, $totalNumberOfDataSourcesBefore - 1, "the number of total data_source should be the same ");

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
