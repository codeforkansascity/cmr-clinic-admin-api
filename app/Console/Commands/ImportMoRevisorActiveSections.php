<?php

namespace App\Console\Commands;

use App\ImportMoRevisorActiveSection;
use App\Jurisdiction;
use App\Lib\CsvImporter;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class ImportMoRevisorActiveSections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:import-mo-revisor-active-sections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load Active Sections from MO Revisor publication page';

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

        $imports = [
            [
                'filename' => 'pdata/mo-revisor-active-sections-cleaned.txt',
                'table' => (new ImportMoRevisorActiveSection())->getTable(),
                'callback' => function ($row) {

                    // Clean up  '\x97', https://stackoverflow.com/questions/1176904/how-to-remove-all-non-printable-characters-in-a-string
                    //    $row['charge_code'] = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $row['charge_code']);
                    if (empty($row['number'])) {
                        $row['number'] = 'Missing';
                    }
                    $row['jurisdiction_id'] = Jurisdiction::JURISDICTION_MO;

                    $row['law_date'] = $this->parseDate($row['law_date']);

                    return $row;
                },
                'header' => [
                    'number',
                    'description',
                    'law_date'
                ]

            ],

        ];

        foreach ($imports as $import) {
            $this->info("Importing {$import['filename']} to {$import['table']}");

            $importer = new CsvImporter(base_path('/' . $import['filename']), $import['header'], "\t");
            $importer->toDatabase($import['table'], $import['callback']);
        }


        return 0;
    }

    protected function parseDate($value)
    {
        try {
            $date = !empty($value) && (new Carbon())->isValid($value) ? Carbon::parse($value) : null;
        } catch (\Exception $e) {

            return null;
        }

        return $date;

    }
}
