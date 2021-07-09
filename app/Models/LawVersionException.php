<?php

namespace App\Models;


use App\Exception;
use App\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class LawVersionException extends Model
{

    use RecordSignature;

    /**
     * fillable - attributes that can be mass-assigned
     */
    protected $fillable = [
        'id',
        'law_id',
        'exception_id',
        'note'
    ];

    protected $hidden = [
        'active',
        'created_by',
        'modified_by',
        'purged_by',
        'created_at',
        'updated_at',
    ];

    public function exception()
    {
        return $this->belongsTo(Exception::class);
    }

    public function add($attributes)
    {

        try {
            $this->fill($attributes)->save();
        } catch (\Exception $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        } catch (QueryException $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    static public function getStatutesForExceptions($exception_id)
    {
        $thisModel = new static;

        return $thisModel::select(
            'law_exceptions.id',
            'law_exceptions.law_id',
            'law_exceptions.exception_id',
            'law_exceptions.note',
            'laws.id AS law_id',
            'laws.number AS law_number',
            'laws.name AS law_name',
            'laws.common_name AS law_common_name',
            'laws.note AS law_note')
            ->leftJoin('laws', 'laws.id', '=', 'law_exceptions.law_id')
            ->orderBy('laws.name')
            ->where('law_exceptions.exception_id', $exception_id)
            ->get();

    }

    static public function getExceptionsForStatutes($law_id)
    {
        $thisModel = new static;

        return $thisModel::select(
            'law_exceptions.id',
            'law_exceptions.law_id',
            'law_exceptions.exception_id',
            'law_exceptions.note',
            'exceptions.id AS exception_id',
            'exceptions.section AS exception_number',
            'exceptions.name AS exception_name',
            'exceptions.short_name AS exception_common_name',
            'exceptions.attorney_note AS exception_note',
            'exceptions.dyi_note AS exception_note',
            'exceptions.logic AS exception_logic'
        )
            ->leftJoin('exceptions', 'exceptions.id', '=', 'law_exceptions.law_id')
            ->orderBy('exceptions.section')
            ->where('law_exceptions.law_id', $law_id)
            ->get();

    }

}
