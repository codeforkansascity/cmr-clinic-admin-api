<?php

namespace App\Console\Commands;

use App\Statute;
use Illuminate\Console\Command;

class UpdateStateStatutesWithoutJurisdiction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:update-state-statutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $count = Statute::where('number', 'REGEXP', '^[0-9]{3}\.[0-9]{2,3}')->whereNull('jurisdiction_id')->count();

        $this->info("Updating jurisdiction_id for $count records");
        Statute::where('number', 'REGEXP', '^[0-9]{3}\.[0-9]{2,3}')->whereNull('jurisdiction_id')
            ->update(['jurisdiction_id' => 1]);

        $this->info("Done updating");

        return 0;
    }
}
