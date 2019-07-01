<?php

use App\User;
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

            $user = \App\User::create([
                'email' => 'paulb@savagesoft.com',
                'name' => 'Paul Barham',
                'password' => bcrypt('secret')
            ]);

    }
}
