<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature;

class Conviction extends Model
{

    use RecordSignature;

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
        'notes',
        'approximate_date_of_charge',
        'created_by',
        'modified_by',
    ];


}
