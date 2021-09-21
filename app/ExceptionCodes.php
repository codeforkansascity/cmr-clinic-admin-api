<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExceptionCodes extends Model
{
    const APPLIES = '1';
    const DOES_NOT_APPLY = '2';
    const POSSIBLY_APPLIES = '3';
    const UNDETERMINED = '4';
    const ELIGIBLITY_STATUSES = [
        self::APPLIES,
        self::DOES_NOT_APPLY,
        self::POSSIBLY_APPLIES,
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
