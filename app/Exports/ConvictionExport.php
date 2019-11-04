<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ConvictionExport implements FromQuery, WithHeadings, WithMapping
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
                        'applicant_id',
                        'name',
                        'arrest_date',
                        'case_number',
                        'agency',
                        'court_name',
                        'court_city_county',
                        'judge',
                        'record_name',
                        'release_status',
                        'release_date_text',
                        'notes',
                        'date_of_charge',
                        'release_date',
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($conviction): array
    {
        return [

                        $conviction->id,
                        $conviction->applicant_id,
                        $conviction->name,
                        $conviction->arrest_date,
                        $conviction->case_number,
                        $conviction->agency,
                        $conviction->court_name,
                        $conviction->court_city_county,
                        $conviction->judge,
                        $conviction->record_name,
                        $conviction->release_status,
                        $conviction->release_date_text,
                        $conviction->notes,
                        $conviction->date_of_charge,
                        $conviction->release_date,
                    ];
    }
}
