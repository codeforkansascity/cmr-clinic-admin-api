<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromQuery, WithHeadings, WithMapping
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
                        'email',
                        'active',
                        'roles'/*,
                        'email_verified_at',
                        'password',
                        'remember_token',*/
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($user): array
    {
        $roles = [];
        foreach($user->roles as $role) {
            $roles[] = $role->name;
        }
        sort($roles);
        $roles = implode(', ', $roles);

        return [

                        $user->id,
                        $user->name,
                        $user->email,
                        $user->active ? 'Yes' : '',
                        $roles
                        /*,
                        $user->email_verified_at,
                        $user->password,
                        $user->remember_token,*/
                    ];
    }
}
