<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class OauthPersonalAccessClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<EOM
        INSERT INTO oauth_personal_access_clients  (`id`, `client_id`,`created_at`,`updated_at`)
        VALUES 
        ('1', '1', '2019-06-29', '2019-06-29');

EOM;
        try {
            DB::connection()->getPdo()->exec($sql);
        } catch (\Exception $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }

    }
}
