<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicantExport implements FromQuery, WithHeadings, WithMapping
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
                        'address_line_1',
                        'address_line_2',
                        'city',
                        'state',
                        'zip_code',
                        'license_number',
                        'license_issuing_state',
                        'previous_expungements',
                        'previous_felony_expungements',
                        'previous_misdemeanor_expungements',
                        'notes',
                        'external_ref',
                        'any_pending_cases',
                        'deleted_at',
                        'status_id',
                        'dob',
                        'license_expiration_date',
                        'cms_client_number',
                        'cms_matter_number',
                        'assignment_id',
                        'step_id',
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($applicant): array
    {
        return [

                        $applicant->id,
                        $applicant->name,
                        $applicant->phone,
                        $applicant->email,
                        $applicant->sex,
                        $applicant->race,
                        $applicant->address_line_1,
                        $applicant->address_line_2,
                        $applicant->city,
                        $applicant->state,
                        $applicant->zip_code,
                        $applicant->license_number,
                        $applicant->license_issuing_state,
                        $applicant->previous_expungements,
                        $applicant->previous_felony_expungements,
                        $applicant->previous_misdemeanor_expungements,
                        $applicant->notes,
                        $applicant->external_ref,
                        $applicant->any_pending_cases,
                        $applicant->deleted_at,
                        $applicant->status_id,
                        $applicant->dob,
                        $applicant->license_expiration_date,
                        $applicant->cms_client_number,
                        $applicant->cms_matter_number,
                        $applicant->assignment_id,
                        $applicant->step_id,
                    ];
    }
}
