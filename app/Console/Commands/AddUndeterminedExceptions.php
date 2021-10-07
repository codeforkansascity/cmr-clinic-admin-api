<?php

namespace App\Console\Commands;

use App\ExceptionCodes;
use App\Jurisdiction;
use App\Statute;
use App\StatuteException;
use Illuminate\Console\Command;

class AddUndeterminedExceptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:add-undetermined-exceptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Undetermined Exception to Statutes where a exception does not exist';

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

        // For all missouri statutes

        $allMoStatutes = Statute::select('id')
            ->where('jurisdiction_id', Jurisdiction::JURISDICTION_MO)
            ->get();

        foreach ($allMoStatutes as $law) {
            // For all exceptions that do not exist


            for ($exception_id = 1; $exception_id <= 11; $exception_id++) {  // Should this be a query?

                $statues_exception = StatuteException::select('id')
                    ->where('statute_id', $law->id)
                    ->where('exception_id', $exception_id)
                    ->first();
                if (!$statues_exception) {
                    // Add a Undetermined one
                    StatuteException::updateOrCreate([
                        'statute_id' => $law->id,
                        'exception_id' => $exception_id],
                        ['source' => 'Automaticly added',
                            'exception_code_id' => ExceptionCodes::UNDETERMINED,
                        ]);
                }
            }
        }





        return 0;
    }
}
