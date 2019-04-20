<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conviction_id',
        'charge',
        'citation',
        'class',
        'type',
        'sentence',
        'convicted',
        'eligible',
        'expunge',
        'note',
    ];


}
