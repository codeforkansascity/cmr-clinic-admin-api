<?php

namespace App;

use App\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class StatuteException extends Model
{

    use RecordSignature;

    /**
     * fillable - attributes that can be mass-assigned
     */
    protected $fillable = [
        'id',
        'statute_id',
        'exception_id',
        'note',
        'attorney_note',
        'dyi_note',
        'source',
        'exception_code_id',

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

    public function exception_code()
    {
        return $this->belongsTo(ExceptionCodes::class);
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
            'statute_exceptions.id',
            'statute_exceptions.statute_id',
            'statute_exceptions.exception_id',
            'statute_exceptions.note',
            'statute_exceptions.attorney_note',
            'statute_exceptions.dyi_note',
            'statute_exceptions.source',
            'exception_codes.name AS exception_code',

            'statutes.id AS statute_id',
            'statutes.number AS statute_number',
            'statutes.name AS statute_name',
            'statutes.common_name AS statute_common_name',
            'statutes.note AS statute_note')
            ->leftJoin('exception_codes', 'exception_codes.id', '=', 'statute_exceptions.exception_code_id')
            ->leftJoin('statutes', 'statutes.id', '=', 'statute_exceptions.statute_id')
            ->orderBy('statutes.name')
            ->where('statute_exceptions.exception_id', $exception_id)
            ->get();

    }

    static public function getStatutesForExceptionsPossible($exception_id)
    {
        $thisModel = new static;

        return $thisModel::select(
            'statute_exceptions.id',
            'statute_exceptions.statute_id',
            'statute_exceptions.exception_id',
            'statute_exceptions.note',
            'statute_exceptions.attorney_note',
            'statute_exceptions.dyi_note',
            'statute_exceptions.source',
            'exception_codes.name AS exception_code',

            'statutes.id AS statute_id',
            'statutes.number AS statute_number',
            'statutes.name AS statute_name',
            'statutes.common_name AS statute_common_name',
            'statutes.note AS statute_note')
            ->leftJoin('exception_codes', 'exception_codes.id', '=', 'statute_exceptions.exception_code_id')
            ->leftJoin('statutes', 'statutes.id', '=', 'statute_exceptions.statute_id')
            ->orderBy('statutes.name')
            ->where('statute_exceptions.exception_id', $exception_id)
            ->whereNotIn('exception_code_id',[ExceptionCodes::DOES_NOT_APPLY, ExceptionCodes::UNDETERMINED])
            ->get();

    }

    static public function getExceptionsForStatutes($statute_id)
    {
        $thisModel = new static;

        return $thisModel::select(
            'statute_exceptions.id',
            'statute_exceptions.statute_id',
            'statute_exceptions.exception_id',
            'statute_exceptions.note',
            'exceptions.id AS exception_id',
            'exceptions.section AS exception_number',
            'exceptions.name AS exception_name',
            'exceptions.short_name AS exception_common_name',
            'exceptions.attorney_note AS exception_note',
            'exceptions.dyi_note AS exception_note',
            'exceptions.logic AS exception_logic'
        )
            ->leftJoin('exceptions', 'exceptions.id', '=', 'statute_exceptions.statute_id')
            ->orderBy('exceptions.section')
            ->where('statute_exceptions.statute_id', $statute_id)
            ->get();

    }

}
