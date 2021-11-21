<?php

namespace App;

use App\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

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
        } catch (\Illuminate\Database\QueryException $e) {
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

    static public function getStatutesForBase()
    {
        $thisModel = new static;

        $query = $thisModel::select(
            'statute_exceptions.id',
            'statute_exceptions.statute_id',
            'statute_exceptions.exception_id',
            'statute_exceptions.note',
            'statute_exceptions.attorney_note',
            'statute_exceptions.dyi_note',
            'statute_exceptions.source',
            'exception_codes.name AS exception_code',
            'exceptions.section AS exception',
            'statutes.id AS statute_id',
            'statutes.number AS statute_number',
            'statutes.name AS statute_name',
            'statutes.common_name AS statute_common_name',
            'statutes.note AS statute_note',
            DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(statutes.number, '.', 1), '.', -1) as cap"),
            DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(statutes.number, '.', 2), '.', -1) as sec")




        )





            ->leftJoin('exception_codes', 'exception_codes.id', '=', 'statute_exceptions.exception_code_id')
            ->leftJoin('exceptions', 'exceptions.id', '=', 'statute_exceptions.exception_id')
            ->leftJoin('statutes', 'statutes.id', '=', 'statute_exceptions.statute_id')
            ->orderBy('exceptions.sequence')
            ->orderBy('cap')
            ->orderBy('sec')
//            ->where('statute_exceptions.exception_id', $exception_id)
            ->whereNotIn('exception_code_id',[ExceptionCodes::DOES_NOT_APPLY]);

        return $query;

    }


    static public function getStatutesForExceptionsPossibleQuery($exception_id)
    {
        $thisModel = new static;

        $query = $thisModel->getStatutesForBase();
        $query->where('statute_exceptions.exception_id', $exception_id);

        return $query;

    }

    static public function getStatutesForExceptionsReportQuery()
    {
        $thisModel = new static;

        $query = $thisModel->getStatutesForBase();

        return $query;

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


    public function canDelete()
    {
        return true;
    }


    /**
     * Get Grid/index data PAGINATED
     *
     * @param $per_page
     * @param $column
     * @param $direction
     * @param string $keyword
     * @return mixed
     */
    static function indexData(
        $per_page,
        $column,
        $direction,
        $keyword = '')
    {
        return self::buildBaseGridQuery($column, $direction, $keyword,
            [ 'id',
                    'statute_id',
                    'exception_id',
                    'note',
                    'attorney_note',
                    'dyi_note',
                    'source',
                    'exception_code_id',
            ])
        ->paginate($per_page);
    }




    /**
     * Create base query to be used by Grid, Download, and PDF
     *
     * NOTE: to override the select you must supply all fields, ie you cannot add to the
     *       fields being selected.
     *
     * @param $column
     * @param $direction
     * @param string $keyword
     * @param string|array $columns
     * @return mixed
     */

    static function buildBaseGridQuery(
        $column,
        $direction,
        $keyword = '',
        $columns = '*')
    {
        // Map sort direction from 1/-1 integer to asc/desc sql keyword
        switch ($direction) {
            case '1':
                $direction = 'desc';
                break;
            case '-1':
                $direction = 'asc';
                break;
            default:
                $direction = 'asc';
                break;
        }

        $query = StatuteException::select($columns)
        ->orderBy($column, $direction);

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }

        /**
         * Get export/Excel/download data query to send to Excel download library
         *
         * @param $per_page
         * @param $column
         * @param $direction
         * @param string $keyword
         * @return mixed
         */

    static function exportDataQuery(
        $column,
        $direction,
        $keyword = '',
        $columns = '*')
    {

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $keyword");

        return self::buildBaseGridQuery($column, $direction, $keyword, $columns);

    }

        static function pdfDataQuery(
            $column,
            $direction,
            $keyword = '',
            $columns = '*')
        {

            info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $keyword");

            return self::buildBaseGridQuery($column, $direction, $keyword, $columns);

        }


    /**
     * Get "options" for HTML select tag
     *
     * If flat return an array.
     * Otherwise, return an array of records.  Helps keep in proper order durring ajax calls to Chrome
     */
    static public function getOptions($flat = false)
    {

        $thisModel = new static;

        $records = $thisModel::select('id',
            'name')
            ->orderBy('name')
            ->get();

        if (!$flat) {
            return $records;
        } else {
            $data = [];

            foreach ($records AS $rec) {
                $data[] = ['id' => $rec['id'], 'name' => $rec['name']];
            }

            return $data;
        }

    }

}
