<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature;

class Client extends Model
{

    use RecordSignature;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
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
        'created_by',
        'modified_by',
    ];


}
