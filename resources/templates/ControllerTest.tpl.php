<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\[[display_singular]];
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class [[model_uc]]ControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class [[model_uc]]ControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_[[model_singular]]_index()
    {
        $response = $this->get('/[[view_folder]]');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_[[model_singular]]()
    {
        $response = $this->get(route('[[view_folder]].create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_[[model_singular]]()
    {
        $response = $this->get(route('[[view_folder]].store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_[[model_singular]]()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('[[view_folder]].show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_[[model_singular]]()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('[[view_folder]].edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_[[model_singular]]()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('[[view_folder]].update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_[[model_singular]]()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('[[view_folder]].destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_[[model_singular]]_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/[[view_folder]]');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_[[model_singular]]()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('[[view_folder]].create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_[[model_singular]]()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('[[view_folder]].store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_[[model_singular]]()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('[[view_folder]].show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_[[model_singular]]()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('[[view_folder]].edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_[[model_singular]]()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('[[view_folder]].update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_[[model_singular]]()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('[[view_folder]].destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_[[model_singular]]()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('[[view_folder]].create'));

        $response->assertRedirect('[[view_folder]]');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_[[model_singular]]()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('[[view_folder]].store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_[[model_singular]]()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('[[view_folder]].show', ['id' => 1]));

        $response->assertRedirect('[[view_folder]]');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_[[model_singular]]()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('[[view_folder]].edit', ['id' => 1]));

        $response->assertRedirect('[[view_folder]]');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_[[model_singular]]()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('[[view_folder]].update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_[[model_singular]]()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('[[view_folder]].destroy', ['id' => 1]));

        $response->assertRedirect('[[view_folder]]');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_[[model_singular]]()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('[[view_folder]].show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find [[display_name_singular]] to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_[[model_singular]]()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('[[view_folder]].edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find [[display_name_singular]] to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_[[model_singular]]()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('[[view_folder]].create'));

        $response->assertStatus(200);
        $response->assertViewIs('[[view_folder]].create');
        $response->assertSee('[[view_folder]]-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_[[model_singular]]()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
[[foreach:grid_columns]]
            '[[i.name]]' => "",
[[endforeach]]
        ];

        $totalNumberOf[[display_uc_plural]]Before = [[display_singular]]::count();

        $response = $this->actingAs($user)->post(route('[[view_folder]].store'), $data);

        $totalNumberOf[[display_uc_plural]]After = [[display_singular]]::count();
        $this->assertEquals($totalNumberOf[[display_uc_plural]]After, $totalNumberOf[[display_uc_plural]]Before, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_[[model_singular]]()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
[[foreach:grid_columns]]
            '[[i.name]]' => "a",
[[endforeach]]
        ];

        $totalNumberOf[[display_uc_plural]]Before = [[display_singular]]::count();

        $response = $this->actingAs($user)->post(route('[[view_folder]].store'), $data);

        $totalNumberOf[[display_uc_plural]]After = [[display_singular]]::count();
        $this->assertEquals($totalNumberOf[[display_uc_plural]]After, $totalNumberOf[[display_uc_plural]]Before, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_[[model_singular]]()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
[[foreach:grid_columns]]
[[if:i.name=='name']]
          'name' => $faker->name,
[[endif]]
[[if:i.name!='name']]
          '[[i.name]]' => "",
[[endif]]
[[endforeach]]
        ];

        info('--  [[display_singular]]  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOf[[display_uc_plural]]Before = [[display_singular]]::count();

        $response = $this->actingAs($user)->post(route('[[view_folder]].store'), $data);

        $totalNumberOf[[display_uc_plural]]After = [[display_singular]]::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOf[[display_uc_plural]]After, $totalNumberOf[[display_uc_plural]]Before + 1, "the number of total [[model_singular]] is supposed to be one more ");

        $lastInsertedInTheDB = [[display_singular]]::orderBy('id', 'desc')->first();

[[foreach:grid_columns]]

        $this->assertEquals($lastInsertedInTheDB->[[i.name]], $data['[[i.name]]'], "the [[i.name]] of the saved [[model_singular]] is different from the input data");

[[endforeach]]

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_[[model_singular]]()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOf[[display_uc_plural]]Before = [[display_singular]]::count();

        $[[model_singular]] = [[display_singular]]::get()->random();
        $data = [
            'id' => "",
[[foreach:grid_columns]]
[[if:i.name=='name']]
            'name' => $[[model_singular]]->name,
[[endif]]
[[if:i.name!='name']]
            '[[i.name]]' => "",
[[endif]]
[[endforeach]]
        ];

        $response = $this->actingAs($user)->post(route('[[view_folder]].store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOf[[display_uc_plural]]After = [[display_singular]]::count();
        $this->assertEquals($totalNumberOf[[display_uc_plural]]After, $totalNumberOf[[display_uc_plural]]Before, "the number of total [[model_singular]] should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_[[model_singular]]()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [[display_singular]]::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOf[[display_uc_plural]]Before = [[display_singular]]::count();

        $response = $this->actingAs($user)->json('PATCH', '[[view_folder]]/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOf[[display_uc_plural]]After = [[display_singular]]::count();
        $this->assertEquals($totalNumberOf[[display_uc_plural]]After, $totalNumberOf[[display_uc_plural]]Before, "the number of total [[model_singular]] should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_[[model_singular]]()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [[display_singular]]::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one [[model_singular]] record
        $[[model_singular]]_dup = [

[[foreach:grid_columns]]
[[if:i.name=='name']]
            'name' => $faker->name,
[[endif]]
[[if:i.name!='name']]
            '[[i.name]]' => "",
[[endif]]
[[endforeach]]
        ];

        $response = $this->actingAs($user)->post(route('[[view_folder]].store'), $[[model_singular]]_dup);


        $data['name'] = $[[model_singular]]_dup['name'];

        $totalNumberOf[[display_uc_plural]]Before = [[display_singular]]::count();

        $response = $this->actingAs($user)->json('PATCH', '[[view_folder]]/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOf[[display_uc_plural]]After = [[display_singular]]::count();
        $this->assertEquals($totalNumberOf[[display_uc_plural]]After, $totalNumberOf[[display_uc_plural]]Before, "the number of total [[model_singular]] should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_[[model_singular]]()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [[display_singular]]::get()->random()->toArray();


        $totalNumberOf[[display_uc_plural]]Before = [[display_singular]]::count();

        $response = $this->actingAs($user)->json('DELETE', '[[view_folder]]/' . $data['id'], $data);

        $totalNumberOf[[display_uc_plural]]After = [[display_singular]]::count();
        $this->assertEquals($totalNumberOf[[display_uc_plural]]After, $totalNumberOf[[display_uc_plural]]Before - 1, "the number of total [[model_singular]] should be the same ");

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
