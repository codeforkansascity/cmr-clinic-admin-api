<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExceptionExport implements FromQuery, WithHeadings, WithMapping
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
                        'section',
                        'name',
                        'short_name',
                        'attorney_note',
                        'dyi_note',
                        'logic',
                        'sequence',
                        'deleted_at',
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($exception): array
    {
        return [

                        $exception->id,
                        $exception->section,
                        $exception->name,
                        $exception->short_name,
                        $exception->attorney_note,
                        $exception->dyi_note,
                        $exception->logic,
                        $exception->sequence,
                        $exception->deleted_at,
                    ];
    }
}
