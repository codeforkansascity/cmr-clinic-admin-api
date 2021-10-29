<?php

use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $user = \App\User::create([
//            'id' => 1,
            'email' => 'paulb@savagesoft.com',
            'name' => 'Paul Barham',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
        ]);
        $user->assignRole('super-admin');

        $user = \App\User::create([
//            'id' => 2,
            'email' => 'motionl@icloud.com',
            'name' => 'Scott Stockwell',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
        ]);
        $user->assignRole('read-only');

        $user = \App\User::create([
//            'id' => 3,
            'email' => 'sunie@umkc.edu',
            'name' => 'Suni, Ellen',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
        ]);
        $user->assignRole('read-only');

        $user = \App\User::create([
//            'id' => 4,
            'email' => 'prattsj@umkc.edu',
            'name' => 'Pratt, Staci Jean',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
        ]);
        $user->assignRole('read-only');

        $user = \App\User::create([
//            'id' => 5,
            'email' => 'ajmia@umkc.edu',
            'name' => 'Ajmi, Ayyoub',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
        ]);
        $user->assignRole('read-only');

        $user = \App\User::create([
//            'id' => 6,
            'email' => 'debra.allen@umkc.edu',
            'name' => 'Allen, Debra',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
        ]);
        $user->assignRole('read-only');

        $user = \App\User::create([
//            'id' => 7,
            'email' => 'bob.smith@gmail.com',
            'name' => 'Bob Smith',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
        ]);
        $user->assignRole('Volunteer Lawyer');


//        $user = \App\User::create([
//            'email' => 'paulb+cant@savagesoft.com',
//            'name' => 'No Access',
//            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
//        ]);
//        $user->assignRole('cant');
//
//        $user = \App\User::create([
//            'email' => 'paulb+cmradmin@savagesoft.com',
//            'name' => 'cmradmin',
//            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
//        ]);
//        $user->assignRole('cmr-admin');
//
//        $user = \App\User::create([
//            'email' => 'paulb+onlyindex@savagesoft.com',
//            'name' => 'onlyindex',
//            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
//        ]);
//        $user->assignRole('only index');
//
//        $user = \App\User::create([
//            'email' => 'paulb+readonly@savagesoft.com',
//            'name' => 'readonly',
//            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
//        ]);
//        $user->assignRole('read-only');
//
//        $user = \App\User::create([
//            'email' => 'camilo.snapp@gmail.com',
//            'name' => 'Camilo Snapp',
//            'password' => bcrypt(env('TEST_USER_PASSWORD', 'secret')),
//        ]);
//        $user->assignRole('read-only');
//
//        factory(App\User::class, 4)->create()->each(function ($user) {
//            $role = \App\Role::inRandomOrder()->first();
//            $user->assignRole($role->name);
//        });
    }
}
