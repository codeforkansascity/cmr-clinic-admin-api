<?php

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<EOM
            INSERT INTO oauth_clients (`id`,`user_id`,`name`,`secret`,`redirect`, `personal_access_client`,
                                       `password_client`,`revoked`,`created_at`,`updated_at`)
            VALUES
              ('1', NULL, 'LaravelPersonalAccessClient', '68memCcpriAKB1EIhzphqeGh11Gqylj83ir5FtEs', 'http', '1', '0', '0', '2019-06-29', '2019-06-29'),
                   ('2', NULL, 'LaravelPasswordGrantClient', 'kGXiC9y7DHQ0zyKb5rJjKH2B4xxi49Zfk6Tn2Q00', 'http', '0', '1', '0', '2019-06-29', '2019-06-29');
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
