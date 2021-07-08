<?php

namespace App\Console\Commands;

use App\Lib\ParseCrimes;
use App\Statute;
use Illuminate\Console\Command;

class LoadStatutesFromScott extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:load-scott-statutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Load statutes from Scott Person's Word documents";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $eligible_file = base_path('/doc/LIST OF CRIMES ELIGIBLE FOR EXPUNGEMENT.docx');
        $ineligible_file = base_path('/doc/LIST OF CRIMES not eligible for expungement.docx');

        Statute::truncate();

        $eligibles = (new ParseCrimes)($eligible_file);

        $ineligibles = (new ParseCrimes)($ineligible_file);

        $eligibles = array_map(function ($e) {
            $e['statutes_eligibility_id'] = Statute::ELIGIBLE;
            $e['created_at'] = now();
            $e['updated_at'] = now();

            return $e;
        }, $eligibles);
        Statute::insert($eligibles);

        $ineligibles = array_map(function ($i) {
            $i['statutes_eligibility_id'] = Statute::INELIGIBLE;
            $i['created_at'] = now();
            $i['updated_at'] = now();

            return $i;
        }, $ineligibles);
        Statute::insert($ineligibles);

        $statute_count = count($ineligibles) + count($eligibles);
        dump("Inserted $statute_count Statutes");
    }
}
