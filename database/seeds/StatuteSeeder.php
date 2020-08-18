<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatuteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $start = microtime(1);
        $eligible_file = base_path('/doc/LIST OF CRIMES ELIGIBLE FOR EXPUNGEMENT.docx');
        $ineligible_file = base_path('/doc/LIST OF CRIMES not eligible for expungement.docx');

        DB::unprepared('set FOREIGN_KEY_CHECKS=0');
        \App\Statute::truncate();
        DB::unprepared('set FOREIGN_KEY_CHECKS=1');

        $statute = \App\Statute::create([
            'id' => 1,
            'number' => '195.211',
            'name' => 'Distribution, Delivery, Manufacture or Production of a Controlled Substance',
            'note' => '',
            'statutes_eligibility_id' => '4',
        ]);
        $statute = \App\Statute::create([
            'id' => 2,
            'number' => '195.223',
            'name' => 'Posession of Drug Paraphernalia',
            'note' => '',
            'statutes_eligibility_id' => '4',
        ]);
        $statute = \App\Statute::create([
            'id' => 3,
            'number' => '2006-034',
            'name' => 'Failing to Drive Within A Single Lane 304.015 R.S. Mo. deemed an Infraction',
            'note' => '',
            'statutes_eligibility_id' => '4',
        ]);

        $eligibles = (new \App\Lib\ParseCrimes)($eligible_file);

        $ineligibles = (new \App\Lib\ParseCrimes)($ineligible_file);

        $eligibles = array_map(function ($e) {
            $e['statutes_eligibility_id'] = \App\Statute::ELIGIBLE;
            $e['created_at'] = now();
            $e['updated_at'] = now();

            return $e;
        }, $eligibles);
        \App\Statute::insert($eligibles);

        $ineligibles = array_map(function ($i) {
            $i['statutes_eligibility_id'] = \App\Statute::INELIGIBLE;
            $i['created_at'] = now();
            $i['updated_at'] = now();

            return $i;
        }, $ineligibles);
        \App\Statute::insert($ineligibles);

        $statute = \App\Statute::create([
            'number' => '579.015',
            'name' => 'Possession or control of a controlled substance',
            'note' => '',
            'statutes_eligibility_id' => '4',
        ]);

        \App\Statute::create([
            'number' => '195.202',
            'name' => 'POSSESSION OF CONTROLLED SUBSTANCE EXCEPT 35 GRAMS OR LESS OF MARIJUANA',
            'note' => '',
            'statutes_eligibility_id' => '4',
            'superseded_id' => $statute->id,
            'superseded_on' => '2014',
        ]);

        $statute_count = count($ineligibles) + count($eligibles);
        dump("Inserted $statute_count Statutes in ".round(microtime(1) - $start, 2).' seconds');
    }
}
