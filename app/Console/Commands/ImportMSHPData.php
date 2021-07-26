<?php

namespace App\Console\Commands;

use App\ImportChargeCode;
use App\ImportMshpChargeCodeManual;
use App\ImportNcic;
use App\ImportNcicModifier;
use App\Lib\CsvImporter;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

class ImportMSHPData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:import-mshp-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Missouri State Highway Patrol Data';

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
                'filename' => 'pdata/May2021ChargeCodeManual.csv',
                'table' => (new ImportMshpChargeCodeManual())->getTable(),
                'callback' => function ($row) {
                    $row['effective_date'] = $this->parseDate($row['effective_date']);
                    return $row;
                },
                'header' => [
                    'charge_code',
                    'ncic_mod',
                    'state_mod',
                    'description',
                    'type_class',
                    'dna',
                    'sor',
                    'roc',
                    'case_type',
                    'effective_date',
                ]

            ],

            [
                'filename' => 'pdata/ChargeCodeCSV2021-5-3.csv',
                'table' => (new ImportChargeCode())->getTable(),
                'callback' => function ($row) {

                    $row['effective_date'] = $this->parseDate($row['effective_date']);
                    $row['inactive_date'] = $this->parseDate($row['inactive_date']);
                    return $row;
                },
                'header' => [
                    'charge_type',
                    'classification',
                    'effective_date',
                    'inactive_date',
                    'reportable',
                    'short_description',
                    'not_applicable',
                    'attempt',
                    'accessory',
                    'conspiracy',
                    'code_category',
                    'ncic_category',
                    'statute',
                    'long_description',
                    'uniform_citation_ind',
                    'rec_of_conviction',
                    'case_type',
                    'charge_code',
                    'dna_at_arrest',
                ]
            ],

            [
                'filename' => 'pdata/NCICCSV2021-5-3.csv',
                'table' => (new ImportNcic())->getTable(),
                'callback' => null,
                'header' => [
                    'ncic_category',
                    'ncic_modifier',
                    'category_description',
                    'modifier_description',
                    'caution',
                ]

            ],

            [
                'filename' => 'pdata/NCICModifiersCSV2021-5-3.csv',
                'table' => (new ImportNcicModifier())->getTable(),
                'callback' => null,
                'header' => [
                    'ncic_category',
                    'ncic_range',
                    'misc',
                    'charge_code',
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
