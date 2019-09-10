<?php

namespace Tests\Feature;

use function MongoDB\BSON\toJSON;
use Tests\TestCase;

use App\Comment;
use Faker;

//use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use DB;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class CommentControllerTest
 *
 * 1. Test that you must be logged in to access any of the controller functions.
 *
 * @package Tests\Feature
 */
class CommentControllerTest extends TestCase
{

    //use RefreshDatabase;
    //------------------------------------------------------------------------------
    // Test that you must be logged in to access any of the controller functions.
    //------------------------------------------------------------------------------

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_seeing_comment_index()
    {
        $response = $this->get('/comment');

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_creating_comment()
    {
        $response = $this->get(route('comment.create'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_storing_comment()
    {
        $response = $this->get(route('comment.store'));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_showing_comment()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('comment.show', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_editing_comment()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->get(route('comment.edit', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_updateing_comment()
    {
        // Should check for permisson before checking to see if record exists
        $response = $this->put(route('comment.update', ['id' => 1]));
        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }


    /**
     * @test
     */
    public function prevent_non_logged_in_users_from_destroying_comment()
    {

        // Should check for permisson before checking to see if record exists
        $response = $this->delete(route('comment.destroy', ['id' => 1]));

        $this->withoutMiddleware();
        $response->assertRedirect('login');
    }

    //------------------------------------------------------------------------------
    // Test that you must have access any of the controller functions.
    //------------------------------------------------------------------------------


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_seeing_comment_index()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get('/comment');

        // TODO: Check for message???

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_creating_comment()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('comment.create'));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_storing_comment()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->post(route('comment.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_showing_comment()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('comment.show', ['id' => 1]));

        $response->assertRedirect('home');
    }

    /**
     * @test
     */
    public function prevent_users_without_permissions_from_editing_comment()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->get(route('comment.edit', ['id' => 1]));

        $response->assertRedirect('home');
    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_updateing_comment()
    {

        $user = $this->getRandomUser('cant');

        $response = $this->actingAs($user)->put(route('comment.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_without_permissions_from_destroying_comment()
    {

        $user = $this->getRandomUser('cant');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('comment.destroy', ['id' => 1]));

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
    public function prevent_users_withonly_index_permissions_from_creating_comment()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('comment.create'));

        $response->assertRedirect('comment');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_storing_comment()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->post(route('comment.store'));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_showing_comment()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->get(route('comment.show', ['id' => 1]));

        $response->assertRedirect('comment');
    }

    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_editing_comment()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->get(route('comment.edit', ['id' => 1]));

        $response->assertRedirect('comment');
    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_updating_comment()
    {

        $user = $this->getRandomUser('only index');

        $response = $this->actingAs($user)->put(route('comment.update', ['id' => 1]));

        $response->assertStatus(403);  // Form Request::authorized() returns 403 when user is not authorized

    }


    /**
     * @test
     */
    public function prevent_users_withonly_index_permissions_from_destroying_comment()
    {

        $user = $this->getRandomUser('only index');

        // Should check for permisson before checking to see if record exists
        $response = $this->actingAs($user)->delete(route('comment.destroy', ['id' => 1]));

        $response->assertRedirect('comment');
    }

    /// ////////

    //------------------------------------------------------------------------------
    // Now lets test that we have the functionality to add, change, delete, and
    //   catch validation errors
    //------------------------------------------------------------------------------
    /**
     * @test
     */
    public function prevent_showing_a_nonexistent_comment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('comment.show',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Comments to display.');

    }

    /**
     * @test
     */
    public function prevent_editing_a_nonexistent_comment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('comment.edit',['id' => 100]));

        $response->assertSessionHas('flash_error_message','Unable to find Comments to edit.');

    }




    /**
     * @test
     */
    public function it_allows_logged_in_users_to_create_new_comment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        // act as the user we got and request the create_new_article route
        $response = $this->actingAs($user)->get(route('comment.create'));

        $response->assertStatus(200);
        $response->assertViewIs('comment.create');
        $response->assertSee('comment-form');

    }

    /**
     * @test
     */
    public function prevent_creating_a_blank_comment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'user_id' => "",
            'body' => "",
            'commentable_type' => "",
            'commentable_id' => "",
        ];

        $totalNumberOfCommentsBefore = Comment::count();

        $response = $this->actingAs($user)->post(route('comment.store'), $data);

        $totalNumberOfCommentsAfter = Comment::count();
        $this->assertEquals($totalNumberOfCommentsAfter, $totalNumberOfCommentsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name field is required.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_invalid_data_when_creating_a_comment()
    {
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
            'id' => "",
            'user_id' => "a",
            'body' => "a",
            'commentable_type' => "a",
            'commentable_id' => "a",
        ];

        $totalNumberOfCommentsBefore = Comment::count();

        $response = $this->actingAs($user)->post(route('comment.store'), $data);

        $totalNumberOfCommentsAfter = Comment::count();
        $this->assertEquals($totalNumberOfCommentsAfter, $totalNumberOfCommentsBefore, "the number of total article is supposed to be the same ");

        $errors = session('errors');

        $this->assertEquals($errors->get('name')[0],"The name must be at least 3 characters.");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function create_a_comment()
    {

        $faker = Faker\Factory::create();
        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = [
          'user_id' => "",
          'body' => "",
          'commentable_type' => "",
          'commentable_id' => "",
        ];

        info('--  Comment  --');
         info(print_r($data,true));
          info('----');

        $totalNumberOfCommentsBefore = Comment::count();

        $response = $this->actingAs($user)->post(route('comment.store'), $data);

        $totalNumberOfCommentsAfter = Comment::count();


        $errors = session('errors');

        info(print_r($errors,true));

        $this->assertEquals($totalNumberOfCommentsAfter, $totalNumberOfCommentsBefore + 1, "the number of total comment is supposed to be one more ");

        $lastInsertedInTheDB = Comment::orderBy('id', 'desc')->first();


        $this->assertEquals($lastInsertedInTheDB->user_id, $data['user_id'], "the user_id of the saved comment is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->body, $data['body'], "the body of the saved comment is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->commentable_type, $data['commentable_type'], "the commentable_type of the saved comment is different from the input data");


        $this->assertEquals($lastInsertedInTheDB->commentable_id, $data['commentable_id'], "the commentable_id of the saved comment is different from the input data");


    }

    /**
     * @test
     *
     * Check validation works
     */
    public function prevent_creating_a_duplicate_comment()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');


        $totalNumberOfCommentsBefore = Comment::count();

        $comment = Comment::get()->random();
        $data = [
            'id' => "",
            'user_id' => "",
            'body' => "",
            'commentable_type' => "",
            'commentable_id' => "",
        ];

        $response = $this->actingAs($user)->post(route('comment.store'), $data);
        $response->assertStatus(302);

        $errors = session('errors');
        $this->assertEquals($errors->get('name')[0],"The name has already been taken.");

        $totalNumberOfCommentsAfter = Comment::count();
        $this->assertEquals($totalNumberOfCommentsAfter, $totalNumberOfCommentsBefore, "the number of total comment should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_changing_comment()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Comment::get()->random()->toArray();

        $data['name'] = $data['name'] . '1';

        $totalNumberOfCommentsBefore = Comment::count();

        $response = $this->actingAs($user)->json('PATCH', 'comment/' . $data['id'], $data);

        $response->assertStatus(200);

        $totalNumberOfCommentsAfter = Comment::count();
        $this->assertEquals($totalNumberOfCommentsAfter, $totalNumberOfCommentsBefore, "the number of total comment should be the same ");

    }



    /**
     * @test
     *
     * Check validation works on change for catching dups
     */
    public function prevent_creating_a_duplicate_by_changing_comment()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Comment::get()->random()->toArray();



        // Create one that we can duplicate the name for, at this point we only have one comment record
        $comment_dup = [

            'user_id' => "",
            'body' => "",
            'commentable_type' => "",
            'commentable_id' => "",
        ];

        $response = $this->actingAs($user)->post(route('comment.store'), $comment_dup);


        $data['name'] = $comment_dup['name'];

        $totalNumberOfCommentsBefore = Comment::count();

        $response = $this->actingAs($user)->json('PATCH', 'comment/' . $data['id'], $data);
        $response->assertStatus(422);  // From web page we get a 422

        $errors = session('errors');

        info(print_r($errors,true));

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.'
            ]);

        $response->assertJsonValidationErrors(['name']);

        $totalNumberOfCommentsAfter = Comment::count();
        $this->assertEquals($totalNumberOfCommentsAfter, $totalNumberOfCommentsBefore, "the number of total comment should be the same ");

    }

    /**
     * @test
     *
     * Check validation works
     */
    public function allow_deleting_comment()
    {

        $faker = Faker\Factory::create();

        // get a random user
        $user = $this->getRandomUser('super-admin');

        $data = Comment::get()->random()->toArray();


        $totalNumberOfCommentsBefore = Comment::count();

        $response = $this->actingAs($user)->json('DELETE', 'comment/' . $data['id'], $data);

        $totalNumberOfCommentsAfter = Comment::count();
        $this->assertEquals($totalNumberOfCommentsAfter, $totalNumberOfCommentsBefore - 1, "the number of total comment should be the same ");

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
