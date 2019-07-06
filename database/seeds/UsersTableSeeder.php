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
        $user = \App\User::create([
            'email' => 'camilo.snapp@gmail.com',
            'name' => 'Camilo Snapp',
            'password' => bcrypt(env('TEST_USER_PASSWORD', $faker->unique()->safeEmail))
        ]);

    }
}
