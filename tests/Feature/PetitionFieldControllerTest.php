<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\PetitionField;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class PetitionFieldControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class PetitionFieldControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_petition_field_index()
    {
        $response = $this->get('/petition-field');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_petition_field()
    {
        $response = $this->get(route('petition-field.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_petition_field()
    {
        $response = $this->get(route('petition-field.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_petition_field()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('petition-field.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_petition_field()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('petition-field.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_petition_field()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('petition-field.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_petition_field()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('petition-field.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_petition_field_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/petition-field');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_petition_field()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('petition-field.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_petition_field()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('petition-field.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_petition_field()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('petition-field.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_petition_field()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('petition-field.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_petition_field()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('petition-field.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_petition_field()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('petition-field.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_petition_field()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('petition-field.create'));

        $response->assertRedirect('petition-field');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_petition_field()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('petition-field.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_petition_field()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('petition-field.show', ['id' => 1]));

        $response->assertRedirect('petition-field');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_petition_field()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('petition-field.edit', ['id' => 1]));

        $response->assertRedirect('petition-field');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_petition_field()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('petition-field.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_petition_field()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('petition-field.destroy', ['id' => 1]));

        $response->assertRedirect('petition-field');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_petition_field()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('petition-field.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Petition Fields to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_petition_field()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('petition-field.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Petition Fields to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_petition_field()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('petition-field.create'));

        $response->assertStatus(200);
        $response->assertViewIs('petition-field.create');
        $response->assertSee('petition-field-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_petition_field()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'applicant_id' => "",
            'petition_number' => "",
            'value' => "",
        ];

        $totalNumberOfPetitionFieldsBefore = PetitionField::count();

        $response = $this->actingAs($user)->post(route('petition-field.store'), $data);

        $totalNumberOfPetitionFieldsAfter = PetitionField::count();
        $this->assertEquals($totalNumberOfPetitionFieldsAfter, $totalNumberOfPetitionFieldsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_petition_field()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'applicant_id' => "a",
            'petition_number' => "a",
            'value' => "a",
        ];

        $totalNumberOfPetitionFieldsBefore = PetitionField::count();

        $response = $this->actingAs($user)->post(route('petition-field.store'), $data);

        $totalNumberOfPetitionFieldsAfter = PetitionField::count();
        $this->assertEquals($totalNumberOfPetitionFieldsAfter, $totalNumberOfPetitionFieldsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_petition_field()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'applicant_id' => "",
          'petition_number' => "",
          'value' => "",
        ];

        info('--  PetitionField  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfPetitionFieldsBefore = PetitionField::count();

        $response = $this->actingAs($user)->post(route('petition-field.store'), $data);

        $totalNumberOfPetitionFieldsAfter = PetitionField::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfPetitionFieldsAfter, $totalNumberOfPetitionFieldsBefore + 1, "the number of total petition_field is supposed to be one more ");

        $lastInsertedInTheDB = PetitionField::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->applicant_id, $data['applicant_id'], "the applicant_id of the saved petition_field is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->petition_number, $data['petition_number'], "the petition_number of the saved petition_field is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->value, $data['value'], "the value of the saved petition_field is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_petition_field()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfPetitionFieldsBefore = PetitionField::count();

        $petition_field = PetitionField::get()->random();
        $data = [
            'id' => "",
            'applicant_id' => "",
            'petition_number' => "",
            'value' => "",
        ];

        $response = $this->actingAs($user)->post(route('petition-field.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfPetitionFieldsAfter = PetitionField::count();
        $this->assertEquals($totalNumberOfPetitionFieldsAfter, $totalNumberOfPetitionFieldsBefore, "the number of total petition_field should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_petition_field()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = PetitionField::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfPetitionFieldsBefore = PetitionField::count();

        $response = $this->actingAs($user)->json('PATCH', 'petition-field/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfPetitionFieldsAfter = PetitionField::count();
        $this->assertEquals($totalNumberOfPetitionFieldsAfter, $totalNumberOfPetitionFieldsBefore, "the number of total petition_field should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_petition_field()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = PetitionField::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one petition_field record
        $petition_field_dup = [

            'applicant_id' => "",
            'petition_number' => "",
            'value' => "",
        ];

        $response = $this->actingAs($user)->post(route('petition-field.store'), $petition_field_dup);


        $data['name'] = $petition_field_dup['name'];

        $totalNumberOfPetitionFieldsBefore = PetitionField::count();

        $response = $this->actingAs($user)->json('PATCH', 'petition-field/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfPetitionFieldsAfter = PetitionField::count();
        $this->assertEquals($totalNumberOfPetitionFieldsAfter, $totalNumberOfPetitionFieldsBefore, "the number of total petition_field should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_petition_field()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = PetitionField::get()->random()->toArray();


        $totalNumberOfPetitionFieldsBefore = PetitionField::count();

        $response = $this->actingAs($user)->json('DELETE', 'petition-field/' . $data['id'], $data);

        $totalNumberOfPetitionFieldsAfter = PetitionField::count();
        $this->assertEquals($totalNumberOfPetitionFieldsAfter, $totalNumberOfPetitionFieldsBefore - 1, "the number of total petition_field should be the same ");

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
