<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ImportMshpChargeCodeExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $dataQuery = null;

    public function __construct($dataQuery)
    {
        $this->dataQuery = $dataQuery;
    }

    public function query()
    {
        return $this->dataQuery;
    }

    ///////////////////////////////////////////////////////////////////////////

    // Add a line of column headings to the top
    public function headings(): array
    {
        return [
                        'id',
                        'mshp_version_id',
                        'cmr_law_number',
                        'cmr_chapter',
                        'legacy_charge_code',
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
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($import_mshp_charge_code): array
    {
        return [

                        $import_mshp_charge_code->id,
                        $import_mshp_charge_code->mshp_version_id,
                        $import_mshp_charge_code->cmr_law_number,
                        $import_mshp_charge_code->cmr_chapter,
                        $import_mshp_charge_code->legacy_charge_code,
                        $import_mshp_charge_code->charge_type,
                        $import_mshp_charge_code->classification,
                        $import_mshp_charge_code->effective_date,
                        $import_mshp_charge_code->inactive_date,
                        $import_mshp_charge_code->reportable,
                        $import_mshp_charge_code->short_description,
                        $import_mshp_charge_code->not_applicable,
                        $import_mshp_charge_code->attempt,
                        $import_mshp_charge_code->accessory,
                        $import_mshp_charge_code->conspiracy,
                        $import_mshp_charge_code->code_category,
                        $import_mshp_charge_code->ncic_category,
                        $import_mshp_charge_code->statute,
                        $import_mshp_charge_code->long_description,
                        $import_mshp_charge_code->uniform_citation_ind,
                        $import_mshp_charge_code->rec_of_conviction,
                        $import_mshp_charge_code->case_type,
                        $import_mshp_charge_code->charge_code,
                        $import_mshp_charge_code->dna_at_arrest,
                    ];
    }
}
