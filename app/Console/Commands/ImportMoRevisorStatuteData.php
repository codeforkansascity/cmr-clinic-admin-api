<?php

namespace App\Console\Commands;

use App\ImportMoRevisorStatute;
use App\Lib\CsvImporter;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

class ImportMoRevisorStatuteData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:import-mo-revisor-statute-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Missouri Revisor Statute Data';

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
                'filename' => 'pdata/missouri-statutes-list-cleaned.csv',
                'table' => (new ImportMoRevisorStatute())->getTable(),
                'callback' => function ($row) {
                    $row['amended_date'] = $this->parseDate($row['amended_date']);

                    // Clean up  '\x97', https://stackoverflow.com/questions/1176904/how-to-remove-all-non-printable-characters-in-a-string
                //    $row['charge_code'] = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $row['charge_code']);

                    $row['title'] = preg_replace('/[\x00-\x1F\x7F-\xFF]/u', '', $row['title']);
                    $row['chapter_name'] = preg_replace('/[\x00-\x1F\x7F-\xFF]/u', '', $row['chapter_name']);
                    $row['rsmo_section'] = preg_replace('/[\x00-\x1F\x7F-\xFF]/u', '', $row['rsmo_section']);
                    $row['section_title'] = preg_replace('/[\x00-\x1F\x7F-\xFF]/u', '', $row['section_title']);

                    $row['cmr_law_number'] = $row['rsmo_section'];
                    $row['cmr_law_title'] = $row['section_title'];
                    $chapter = explode(".", $row['rsmo_section']);
                    $row['cmr_chapter'] = intval($chapter[0]);

                    return $row;
                },
                'header' => [
                    'title',
                    'chapter_name',
                    'rsmo_section',
                    'section_title',
                    'amended_date',
                    'expungable',
                    'source_law',
                    'source_description'
                ]

            ],


        ];

        foreach ($imports as $import) {
            $this->info("Importing {$import['filename']} to {$import['table']}");

            $importer = new CsvImporter(base_path('/' . $import['filename']), $import['header']);
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
