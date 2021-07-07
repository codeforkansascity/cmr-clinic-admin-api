<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Class LawVersionExport - Export to Excel Spreadsheet.
 */
class LawVersionExport implements FromQuery, WithHeadings, WithMapping
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
                'number',
                'name',
                'common_name',
                'jurisdiction_id',
                'note',
                'statutes_eligibility_id',
                'blocks_time',
                'same_as_id',
                'superseded_id',
                'superseded_on',
                'deleted_at',
                ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($law_version): array
    {
        return [
                $law_version->id,
                $law_version->number,
                $law_version->name,
                $law_version->common_name,
                $law_version->jurisdiction_id,
                $law_version->note,
                $law_version->statutes_eligibility_id,
                $law_version->blocks_time,
                $law_version->same_as_id,
                $law_version->superseded_id,
                $law_version->superseded_on,
                $law_version->deleted_at,
                ];
    }
}
