<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{


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
    ];


}
