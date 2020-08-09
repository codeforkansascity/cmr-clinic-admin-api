<?php

use App\Lib\InitialPermissions;
use Illuminate\Database\Seeder;

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
