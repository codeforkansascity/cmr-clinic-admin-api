<?php

namespace App\Console\Commands;

use App\Statute;
use Illuminate\Console\Command;

class StatutesTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:statutes-transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer Statutes for 610.140.2.6';

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
            '565.084' => '575.095',
            '568.080' => '573.200',
            '578.008' => '574.130',
            '565.085' => '575.155',
            '568.090' => '573.205',
            '578.305' => '577.703',
            '565.086' => '575.157',
            '569.030' => '570.025',
            '578.310' => '577.706',
            '565.095' => '574.140',
            '569.072' => '577.078',
            '565.200' => '566.116',
            '577.054' => '610.130',
        ];

//        610.130.   Alcohol-related driving offenses, expunged from records, when — procedures, effect — limitations.

        foreach ($statutes as $statute_previous_number => $current_statute_number) {


            $this->addStatute($statute_previous_number, 'The following sections were transferred by S.B. 491, 2014, effective 1-01-17 to ' . $current_statute_number);
            $this->addStatute($current_statute_number, 'Created since ' . $statute_previous_number . ' was transferd to this statute by S.B. 491, 2014, effective 1-01-17');


        }

        return 0;
    }

    private function addStatute($statute_number,$name)
    {
        print "$statute_number ";
        $statute = Statute::where('number', $statute_number)->first();

        $parts = explode('.', $statute_number);
        $statute = Statute::where('number', $statute_number)->first();

        if ($statute) {
            print "Exists\n";
        } else {
            $statute = Statute::create([
                'number' => $statute_number,
                'name' => $name,
                'note' => '',
                'chapter_number' => $parts[0],
                'jurisdiction_id' => 1,
                'statutes_eligibility_id' => Statute::UNDETERMINED
            ]);
        }
        print "Added\n";
    }
}
