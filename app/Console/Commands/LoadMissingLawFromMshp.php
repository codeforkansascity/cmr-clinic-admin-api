<?php

namespace App\Console\Commands;

use App\ImportMoRevisorStatute;
use App\ImportMshpChargeCodeManual;
use App\Statute;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LoadMissingLawFromMshp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:load-missing-law-from-mshp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load Laws from MSHP that do not exist';

    /**
     * Command name to display in the start and end messages
     *
     * @var string
     */
    protected $cmd_title = 'Load Missing Law from MSHP';
    /**
     * Start time in microtime
     *
     * @var int
     */
    var $start_time = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->start_time = microtime(true);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info($this->cmd_title . ": Start");


        $missing_law_numbers = $this->getMissingLawNumbers();

        $this->info('Missing Law Count=|' . $missing_law_numbers->count() . '|');


        $laws_to_add = $this->getLawsToAdd($missing_law_numbers);

        $this->info('Laws to add Count=|' . $laws_to_add->count() . '|');


        $this->addLaws($laws_to_add);




        $this->info($this->createAndLogEndMessage());

        return 0;
    }

    private function addLaws($laws_to_add) {

        foreach ($laws_to_add AS $law) {
            Statute::create(
                [
                    'number' => trim($law['cmr_law_number']),
                    'name' => trim($law['cmr_law_title']),
                    'jurisdiction_id' => 1,
                    'statutes_eligibility_id' => Statute::UNDETERMINED,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    private function getMissingLawNumbers() {
        $missing_law_query = ImportMshpChargeCodeManual::select('cmr_law_number')
            ->leftJoin('statutes', 'statutes.number', '=' , 'import_mshp_charge_code_manuals.cmr_law_number')
            ->groupBy('cmr_law_number')
            ->whereNull('number');

        return $missing_law_query->get()->pluck('cmr_law_number');

    }

    private function getLawsToAdd ($missing_law_numbers) {

        print_r($missing_law_numbers->toArray());
        $laws_to_add_query = ImportMoRevisorStatute::select(
            'cmr_chapter',
            'chapter_name',
            'cmr_law_number',
            'cmr_law_title',
            'amended_date'
        )->whereIn('cmr_law_number',$missing_law_numbers);

        $this->info($laws_to_add_query->toSql());

        return $laws_to_add_query->get();

    }
    /**
     * Create and Log End message with run time
     */
    private function createAndLogEndMessage()
    {
        $msg = $this->cmd_title . ": End, Run Time  = " . (microtime(true) - $this->start_time) . " sec";
        Log::info($msg);
        return $msg;

    }

}
