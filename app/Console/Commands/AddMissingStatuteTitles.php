<?php

namespace App\Console\Commands;

use App\Jurisdiction;
use App\Statute;
use Illuminate\Console\Command;

class AddMissingStatuteTitles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:add-missing-statute-titles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add titles to selected statutes';

    protected $statutes = [
        [
            'number' => '566.212',
            'name' => 'Transferred 2014; now 566.211',


        ]
    ];
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

        Statute::updateOrCreate(

                ['number' => '566.212'],
                [
                    'name' => 'Transferred 2014; now 566.211',
                    'statutes_eligibility_id' => Statute::UNDETERMINED,
                    'jurisdiction_id' => Jurisdiction::JURISDICTION_MO
                ]

        );

        return 0;
    }
}
