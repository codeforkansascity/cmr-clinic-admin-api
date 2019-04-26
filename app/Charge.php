<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature;

class Charge extends Model
{

    use RecordSignature;
    var $table = 'charge';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conviction_id',
        'charge',
        'citation',
        'conviction_class_type',
        'conviction_charge_type',
        'sentence',
        'convicted',
        'eligible',
        'please_expunge',
        'please_print',
        'notes',
        'created_by',
        'modified_by',
    ];


}
