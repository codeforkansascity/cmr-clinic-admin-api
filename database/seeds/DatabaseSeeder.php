<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $start = microtime(1);
        $this->call(SpatiePermissionTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(OauthPersonalAccessClientsTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
        $this->call([StatuteSeeder::class, ServiceSeeder::class]);
        $this->call(ApplicantTableSeeder::class);

        $total = round(microtime(1) -$start, 2);
        dump("Total seed time $total seconds");
    }
}
