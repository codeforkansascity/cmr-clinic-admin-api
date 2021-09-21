<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ImportMshpChargeCodeManualExport implements FromQuery, WithHeadings, WithMapping
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
                        'cmr_charge_code_seq',
                        'cmr_charge_code_fingerprintable',
                        'cmr_charge_code_effective_year',
                        'cmr_charge_code_ncic_category',
                        'cmr_charge_code_ncic_modifier',
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
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($import_mshp_charge_code_manual): array
    {
        return [

                        $import_mshp_charge_code_manual->id,
                        $import_mshp_charge_code_manual->mshp_version_id,
                        $import_mshp_charge_code_manual->cmr_law_number,
                        $import_mshp_charge_code_manual->cmr_chapter,
                        $import_mshp_charge_code_manual->cmr_charge_code_seq,
                        $import_mshp_charge_code_manual->cmr_charge_code_fingerprintable,
                        $import_mshp_charge_code_manual->cmr_charge_code_effective_year,
                        $import_mshp_charge_code_manual->cmr_charge_code_ncic_category,
                        $import_mshp_charge_code_manual->cmr_charge_code_ncic_modifier,
                        $import_mshp_charge_code_manual->charge_code,
                        $import_mshp_charge_code_manual->ncic_mod,
                        $import_mshp_charge_code_manual->state_mod,
                        $import_mshp_charge_code_manual->description,
                        $import_mshp_charge_code_manual->type_class,
                        $import_mshp_charge_code_manual->dna,
                        $import_mshp_charge_code_manual->sor,
                        $import_mshp_charge_code_manual->roc,
                        $import_mshp_charge_code_manual->case_type,
                        $import_mshp_charge_code_manual->effective_date,
                    ];
    }
}
