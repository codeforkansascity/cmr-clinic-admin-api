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
        $this->call(UsersTableSeeder::class);
        $this->call(SpatiePermissionTableSeeder::class);
        $this->call(OauthPersonalAccessClientsTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(ConvictionTableSeeder::class);
        $this->call(ChargeTableSeeder::class);
    }
}
