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
            'password' => bcrypt(env('TEST_USER_PASSWORD', $faker->unique()->safeEmail))
        ]);
        $user->assignRole('super-admin');

        $user = \App\User::create([
            'email' => 'paulb+cant@savagesoft.com',
            'name' => 'No Access',
            'password' => bcrypt('secret')
        ]);
        $user->assignRole('cant');

        $user = \App\User::create([
            'email' => 'camilo.snapp@gmail.com',
            'name' => 'Camilo Snapp',
            'password' => bcrypt(env('TEST_USER_PASSWORD', $faker->unique()->safeEmail))
        ]);
        $user->assignRole('super-admin');

        factory(App\User::class, 40)->create()->each(function ($user) {
            $role = \App\Role::inRandomOrder()->first();
            $user->assignRole($role->name);
        });

    }
}
