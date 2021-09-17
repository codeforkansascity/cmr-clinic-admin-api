<?php

namespace App\Console\Commands;

use App\ImportMoRevisorActiveSection;
use App\ImportMoRevisorStatute;
use App\ImportMshpChargeCodeManual;
use App\Jurisdiction;
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


        $laws_to_add = $this->getLawsMoRevisorDataToAdd($missing_law_numbers);
        $this->info('Laws to add Count=|' . $laws_to_add->count() . '|');
        $this->addLaws($laws_to_add);




        $final_missing_law_numbers = $this->getMissingLawNumbers();
        $this->info('Final Missing Count=|' . $final_missing_law_numbers->count() . '|');
        $this->addFinalMissingLaws($final_missing_law_numbers);



        $this->info($this->createAndLogEndMessage());

        return 0;
    }

    private function addFinalMissingLaws($final_missing_law_numbers) {

        foreach ($final_missing_law_numbers AS $law_number) {

            $law_number = trim($law_number);

            $rec = ImportMoRevisorActiveSection::select('description')
                ->where('jurisdiction_id',Jurisdiction::JURISDICTION_MO)
                ->where('number', $law_number)
                ->first();

            if ($rec) {
                $name = $rec->description;
            } else {
                $name = "Please add title from MO Revisor";
                print "$law_number is missing Title\n";
            }
            Statute::create(
                [
                    'number' => trim($law_number),
                    'name' => $name,
                    'jurisdiction_id' => Jurisdiction::JURISDICTION_MO,
                    'statutes_eligibility_id' => Statute::UNDETERMINED,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
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

    private function getLawsMoRevisorDataToAdd ($missing_law_numbers) {

        $laws_to_add_query = ImportMoRevisorStatute::select(
            'cmr_chapter',
            'chapter_name',
            'cmr_law_number',
            'cmr_law_title',
            'amended_date'
        )->whereIn('cmr_law_number',$missing_law_numbers);

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
