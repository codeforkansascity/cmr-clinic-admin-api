<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    var $table = 'client';


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
        'zip',
        'license_number',
        'license_issuing_state',
        'license_expiration_date',
        'filing_court',
        'judicial_ciruit_number',
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
    ];


}
