<?php

namespace App\Console\Commands;

use App\Statute;
use App\StatutesEligibility;
use Illuminate\Console\Command;

class StatutesRepeal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:statutes-repeal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repeal Statutes  for 610.140.2.6';

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
     * @return int
     */
    public function handle()
    {
        $statutes = [
            '217.360',
            '565.214',
            '569.035',
            '569.067',
            '575.350',
        ];

        foreach ($statutes as $statute_number) {

            print "$statute_number ";
            $parts = explode('.',$statute_number);

            $statute = Statute::where('number',$statute_number)->first();

            if ($statute) {
                $statute->note = 'Repealed by S.B. 491, 2014, effective 1-01-17';
                $statute->save();
                print "Update\n";
            } else {
                $statute = Statute::create([
                    'number' => $statute_number,
                    'name' => 'Repealed by S.B. 491, 2014, effective 1-01-17',
                    'note' => '',
                    'chapter_number' => $parts[0],
                    'jurisdiction_id' => 1,
                    'statutes_eligibility_id' => Statute::UNDETERMINED
                ]);
                print "Added\n";
            }


        }

        return 0;
    }
}
