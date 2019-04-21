<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conviction extends Model
{

    var $table = 'conviction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'name',
        'arrest_date',
        'case_number',
        'agency',
        'court_name',
        'court_city_county',
        'name_of_judge',
        'your_name_in_case',
        'release_status',
        'release_date',
        'judge',
        'record_name',
        'notes'
    ];


}
