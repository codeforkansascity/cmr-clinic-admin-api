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
            'email' => 'paulb@savagesoft.com',
            'name' => 'Paul Barham',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'bird-travel-car')),
        ]);
        $user->assignRole('super-admin');

        $user = \App\User::create([
            'email' => 'motionl@icloud.com',
            'name' => 'Scott Stockwell',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'bird-travel-car')),
        ]);
        $user->assignRole('super-admin');

        $user->assignRole('super-admin');

        $user = \App\User::create([
            'email' => 'bob.smith@gmail.com',
            'name' => 'Bob Smith',
            'password' => bcrypt(env('TEST_USER_PASSWORD', 'bird-travel-car')),
        ]);
        $user->assignRole('Volunteer Lawyer');


        $user = \App\User::create([
            'email' => 'paulb+cant@savagesoft.com',
            'name' => 'No Access',
            'password' => bcrypt('bird-travel-car'),
        ]);
        $user->assignRole('cant');

        $user = \App\User::create([
            'email' => 'paulb+cmradmin@savagesoft.com',
            'name' => 'cmradmin',
            'password' => bcrypt('bird-travel-car'),
        ]);
        $user->assignRole('cmr-admin');

        $user = \App\User::create([
            'email' => 'paulb+onlyindex@savagesoft.com',
            'name' => 'onlyindex',
            'password' => bcrypt('bird-travel-car'),
        ]);
        $user->assignRole('only index');

        $user = \App\User::create([
            'email' => 'paulb+readonly@savagesoft.com',
            'name' => 'readonly',
            'password' => bcrypt('bird-travel-car'),
        ]);
        $user->assignRole('read-only');

        $user = \App\User::create([
            'email' => 'camilo.snapp@gmail.com',
            'name' => 'Camilo Snapp',
            'password' => bcrypt(env('TEST_USER_PASSWORD', $faker->unique()->safeEmail)),
        ]);
        $user->assignRole('super-admin');

        factory(App\User::class, 40)->create()->each(function ($user) {
            $role = \App\Role::inRandomOrder()->first();
            $user->assignRole($role->name);
        });
    }
}
