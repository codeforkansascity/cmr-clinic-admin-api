<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServiceExport implements FromQuery, WithHeadings, WithMapping
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
                        'name',
                        'address',
                        'address_line_2',
                        'city',
                        'state',
                        'zip',
                        'county',
                        'phone',
                        'email',
                        'note',
                        'service_type_id',
                        'deleted_at',
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($service): array
    {
        return [

                        $service->id,
                        $service->name,
                        $service->address,
                        $service->address_line_2,
                        $service->city,
                        $service->state,
                        $service->zip,
                        $service->county,
                        $service->phone,
                        $service->email,
                        $service->note,
                        $service->service_type_id,
                        $service->deleted_at,
                    ];
    }
}
