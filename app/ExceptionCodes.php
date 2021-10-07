<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExceptionCodes extends Model
{
    const APPLIES = '1';
    const POSSIBLY_APPLIES = '2';
    const DOES_NOT_APPLY = '3';
    const RESEARCH = '4';
    const UNDETERMINED = '5';
    const ELIGIBLITY_STATUSES = [
        self::APPLIES,
        self::POSSIBLY_APPLIES,
        self::DOES_NOT_APPLY,
        self::RESEARCH,
        self::UNDETERMINED,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'letter',
        'system_name',
        'sequence'
        ];

}
