<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StatuteExceptionExport implements ShouldAutoSize, FromQuery, WithHeadings, WithMapping
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
            'Exception',
            'Number',
            'Name',
            'Exception',
            'Note',
        ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($statute_exception): array
    {
        return [

            sprintf('%s ',$statute_exception->exception),
            sprintf('%s ',$statute_exception->statute_number),
            trim($statute_exception->statute_name),
            $statute_exception->exception_code,
            $statute_exception->note,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::TYPE_STRING,
        ];
    }
}
