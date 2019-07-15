<?php

use Illuminate\Database\Seeder;
use App\Lib\InitialPermissions;

class SpatiePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perms = new InitialPermissions();
    }
}
