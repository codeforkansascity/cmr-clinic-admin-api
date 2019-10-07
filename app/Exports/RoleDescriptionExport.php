<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RoleDescriptionExport implements FromQuery, WithHeadings, WithMapping
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
                        'role_id',
                        'role_name',
                        'name',
                        'description',
                        'sequence',
                        'roles_that_can_assign',
                        'deleted_at',
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($role_description): array
    {
        return [

                        $role_description->id,
                        $role_description->role_id,
                        $role_description->role_name,
                        $role_description->name,
                        $role_description->description,
                        $role_description->sequence,
                        $role_description->roles_that_can_assign,
                        $role_description->deleted_at,
                    ];
    }
}
