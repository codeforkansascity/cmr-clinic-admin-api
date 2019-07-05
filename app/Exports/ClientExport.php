<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientExport implements FromQuery, WithHeadings, WithMapping
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
                        'phone',
                        'email',
                        'sex',
                        'race',
                        'dob',
                        'address_line_1',
                        'address_line_2',
                        'city',
                        'state',
                        'zip_code',
                        'license_number',
                        'license_issuing_state',
                        'license_expiration_date',
                        'filing_court',
                        'judicial_circuit_number',
                        'count_name',
                        'judge_name',
                        'division_name',
                        'petitioner_name',
                        'division_number',
                        'city_name_here',
                        'county_name',
                        'arresting_county',
                        'prosecuting_county',
                        'arresting_municipality',
                        'other_agencies_name',
                        'previous_expungements',
                        'status',
                        'external_ref',
                        'any_pending_cases',
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($client): array
    {
        return [

                        $client->id,
                        $client->name,
                        $client->phone,
                        $client->email,
                        $client->sex,
                        $client->race,
                        $client->dob,
                        $client->address_line_1,
                        $client->address_line_2,
                        $client->city,
                        $client->state,
                        $client->zip_code,
                        $client->license_number,
                        $client->license_issuing_state,
                        $client->license_expiration_date,
                        $client->filing_court,
                        $client->judicial_circuit_number,
                        $client->count_name,
                        $client->judge_name,
                        $client->division_name,
                        $client->petitioner_name,
                        $client->division_number,
                        $client->city_name_here,
                        $client->county_name,
                        $client->arresting_county,
                        $client->prosecuting_county,
                        $client->arresting_municipality,
                        $client->other_agencies_name,
                        $client->previous_expungements,
                        $client->status,
                        $client->external_ref,
                        $client->any_pending_cases,
                    ];
    }
}
