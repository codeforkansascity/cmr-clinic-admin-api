<?php

namespace App\Console\Commands;

use App\ImportMshpChargeCode;
use App\ImportMshpChargeCodeManual;
use App\ImportMshpNcic;
use App\ImportMshpNcicModifier;
use App\Lib\CsvImporter;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

class Import2020MSHPChargeCodeFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:import-2020-mshp-charge-code-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '2020 Import Missouri State Highway Patrol Data';

    protected $directory = '/';

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

        $this->directory = 'pdata/mo-charge-code/2020-2021-May/';
        $mshp_version_id = 1;

        //    'filename' => 'ChargeCodeManual-cleaned.csv',
        $imports = [
            [
                'filename' => 'ChargeCodeManual-cleaned.csv',
                'table' => (new ImportMshpChargeCodeManual())->getTable(),
                'callback' => function ($row) use ($mshp_version_id) {

                    $row['mshp_version_id'] = $mshp_version_id;

                    $row['effective_date'] = $this->parseDate($row['effective_date']);

                    $row['charge_code'] = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $row['charge_code']);

                    $charge_code = explode("-", $row['charge_code']);
                    $row['cmr_law_number'] = $charge_code[0];

                    $parts = [];
                    preg_match('/(...)(.)(....)(..)(..)/',$charge_code[1],$parts);

                    $row['cmr_charge_code_seq'] = $parts[1];
                    $row['cmr_charge_code_fingerprintable'] = $parts[2];
                    $row['cmr_charge_code_effective_year'] = $parts[3];
                    $row['cmr_charge_code_ncic_category'] = $parts[4];
                    $row['cmr_charge_code_ncic_modifier'] = $parts[5];

                    $chapter = explode(".", $charge_code[0]);
                    $row['cmr_chapter'] = $chapter[0];

                    $row['cmr_attempt'] = str_contains($row['state_mod'],'1');

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
                    'cmr_law_number',
                    'cmr_chapter',
                ]

            ],

            [
                'filename' => 'ChargeCodeCSV.csv',
                'table' => (new ImportMshpChargeCode())->getTable(),
                'callback' => function ($row) use ($mshp_version_id) {

                    $row['mshp_version_id'] = $mshp_version_id;

                    $row['effective_date'] = $this->parseDate($row['effective_date']);
                    $row['inactive_date'] = $this->parseDate($row['inactive_date']);

                    $charge_code = explode("-", $row['charge_code']);
                    $row['cmr_law_number'] = $charge_code[0];

                    $chapter = explode(".", $charge_code[0]);
                    $row['cmr_chapter'] = $chapter[0];

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
                'filename' => 'NCICCSV.csv',
                'table' => (new ImportMshpNcic())->getTable(),
                'callback' => function ($row)  use ($mshp_version_id){

                    $row['mshp_version_id'] = $mshp_version_id;

                    return $row;
                },
                'header' => [
                    'ncic_category',
                    'ncic_modifier',
                    'category_description',
                    'modifier_description',
                    'caution',
                ]

            ],

            [
                'filename' => 'NCICModifiersCSV.csv',
                'table' => (new ImportMshpNcicModifier())->getTable(),
                'callback' => function ($row)  use ($mshp_version_id){

                    $row['mshp_version_id'] = $mshp_version_id;

                    $charge_code = explode("-", $row['charge_code']);
                    $row['cmr_law_number'] = $charge_code[0];

                    $chapter = explode(".", $charge_code[0]);
                    $row['cmr_chapter'] = $chapter[0];

                    $parts = [];
                    if (preg_match('/(...)(.)(....)/',$charge_code[1],$parts)) {
                        $row['cmr_charge_code_seq'] = $parts[1];
                        $row['cmr_charge_code_fingerprintable'] = $parts[2];
                        $row['cmr_charge_code_effective_year'] = $parts[3];
                     //   $row['cmr_charge_code_ncic_category'] = $parts[4];
                     //   $row['cmr_charge_code_ncic_modifier'] = $parts[5];
                    } else {
                        print ('cannot parse ' . $charge_code . "\n");
                    }

                    return $row;
                },
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

            $filename = base_path('/' . $this->directory . $import['filename']);

            if (file_exists($filename)) {
                $importer = new CsvImporter($filename, $import['header']);
                $importer->toDatabase($import['table'], $import['callback']);
            } else {
                $this->error('File does not exist ' . $filename);
            }
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
