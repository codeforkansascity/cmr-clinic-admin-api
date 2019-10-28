<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Applicant;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class ApplicantControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class ApplicantControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_applicant_index()
    {
        $response = $this->get('/applicant');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_applicant()
    {
        $response = $this->get(route('applicant.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_applicant()
    {
        $response = $this->get(route('applicant.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_applicant()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('applicant.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_applicant()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('applicant.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_applicant()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('applicant.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_applicant()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('applicant.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_applicant_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/applicant');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_applicant()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('applicant.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_applicant()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('applicant.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_applicant()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('applicant.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_applicant()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('applicant.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_applicant()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('applicant.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_applicant()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('applicant.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_applicant()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('applicant.create'));

        $response->assertRedirect('applicant');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_applicant()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('applicant.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_applicant()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('applicant.show', ['id' => 1]));

        $response->assertRedirect('applicant');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_applicant()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('applicant.edit', ['id' => 1]));

        $response->assertRedirect('applicant');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_applicant()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('applicant.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_applicant()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('applicant.destroy', ['id' => 1]));

        $response->assertRedirect('applicant');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_applicant()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('applicant.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Applicants to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_applicant()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('applicant.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Applicants to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_applicant()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('applicant.create'));

        $response->assertStatus(200);
        $response->assertViewIs('applicant.create');
        $response->assertSee('applicant-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_applicant()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "",
            'dob' => "",
        ];

        $totalNumberOfApplicantsBefore = Applicant::count();

        $response = $this->actingAs($user)->post(route('applicant.store'), $data);

        $totalNumberOfApplicantsAfter = Applicant::count();
        $this->assertEquals($totalNumberOfApplicantsAfter, $totalNumberOfApplicantsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_applicant()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'name' => "a",
            'dob' => "a",
        ];

        $totalNumberOfApplicantsBefore = Applicant::count();

        $response = $this->actingAs($user)->post(route('applicant.store'), $data);

        $totalNumberOfApplicantsAfter = Applicant::count();
        $this->assertEquals($totalNumberOfApplicantsAfter, $totalNumberOfApplicantsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_applicant()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'name' => $faker->name,
          'dob' => "",
        ];

        info('--  Applicant  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfApplicantsBefore = Applicant::count();

        $response = $this->actingAs($user)->post(route('applicant.store'), $data);

        $totalNumberOfApplicantsAfter = Applicant::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfApplicantsAfter, $totalNumberOfApplicantsBefore + 1, "the number of total applicant is supposed to be one more ");

        $lastInsertedInTheDB = Applicant::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->name, $data['name'], "the name of the saved applicant is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->dob, $data['dob'], "the dob of the saved applicant is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_applicant()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfApplicantsBefore = Applicant::count();

        $applicant = Applicant::get()->random();
        $data = [
            'id' => "",
            'name' => $applicant->name,
            'dob' => "",
        ];

        $response = $this->actingAs($user)->post(route('applicant.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfApplicantsAfter = Applicant::count();
        $this->assertEquals($totalNumberOfApplicantsAfter, $totalNumberOfApplicantsBefore, "the number of total applicant should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_applicant()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Applicant::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfApplicantsBefore = Applicant::count();

        $response = $this->actingAs($user)->json('PATCH', 'applicant/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfApplicantsAfter = Applicant::count();
        $this->assertEquals($totalNumberOfApplicantsAfter, $totalNumberOfApplicantsBefore, "the number of total applicant should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_applicant()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Applicant::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one applicant record
        $applicant_dup = [

            'name' => $faker->name,
            'dob' => "",
        ];

        $response = $this->actingAs($user)->post(route('applicant.store'), $applicant_dup);


        $data['name'] = $applicant_dup['name'];

        $totalNumberOfApplicantsBefore = Applicant::count();

        $response = $this->actingAs($user)->json('PATCH', 'applicant/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfApplicantsAfter = Applicant::count();
        $this->assertEquals($totalNumberOfApplicantsAfter, $totalNumberOfApplicantsBefore, "the number of total applicant should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_applicant()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Applicant::get()->random()->toArray();


        $totalNumberOfApplicantsBefore = Applicant::count();

        $response = $this->actingAs($user)->json('DELETE', 'applicant/' . $data['id'], $data);

        $totalNumberOfApplicantsAfter = Applicant::count();
        $this->assertEquals($totalNumberOfApplicantsAfter, $totalNumberOfApplicantsBefore - 1, "the number of total applicant should be the same ");

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
