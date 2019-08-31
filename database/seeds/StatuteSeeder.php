<?php

use Illuminate\Database\Seeder;

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
       $eligible_file = base_path('/doc/LIST OF CRIMES ELIGIBLE FOR EXPUNGEMENT.docx');
       $ineligible_file = base_path('/doc/LIST OF CRIMES not eligible for expungement.docx');

       \App\Statute::truncate();

       $eligibles = (new \App\Lib\ParseCrimes)($eligible_file);

       $ineligibles = (new \App\Lib\ParseCrimes)($ineligible_file);

       $eligibles = array_map(function($e) {
           $e['eligible'] = \App\Statute::ELIGIBLE;
           $e['created_at'] = now();
           $e['updated_at'] = now();
           return $e;
       }, $eligibles);
       \App\Statute::insert($eligibles);

       $ineligibles = array_map(function($i) {
           $i['eligible'] = \App\Statute::INELIGIBLE;
           $i['created_at'] = now();
           $i['updated_at'] = now();
           return $i;
       }, $ineligibles);
       \App\Statute::insert($ineligibles);

       $statute_count = count($ineligibles) + count($eligibles);
       dump("Inserted $statute_count Statutes");

    }
}
