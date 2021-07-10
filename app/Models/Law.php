<?php

namespace App\Models;

use App\Charge;
use App\Traits\HistoryTrait;
use App\Traits\RecordSignature;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Law extends Model
{
//    use SoftDeletes;
    use RecordSignature;

//    use HistoryTrait;

    const ELIGIBLE = '1';
    const INELIGIBLE = '2';
    const POSSIBLY = '3';
    const UNDETERMINED = '4';
    const ELIGIBLITY_STATUSES = [
        self::ELIGIBLE,
        self::INELIGIBLE,
        self::POSSIBLY,
        self::UNDETERMINED,
    ];

    /**
     * fillable - attributes that can be mass-assigned.
     */
    protected $fillable = [
        'id',
        'law_version_id',
    ];

    protected $hidden = [
        'active',
        'created_by',
        'modified_by',
        'purged_by',
        'created_at',
        'updated_at',
    ];

    public function add($attributes)
    {
        try {
            $this->fill($attributes)->save();
        } catch (Exception $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            throw new Exception($e->getMessage());
        } catch (QueryException $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }

        return true;
    }

    public function canDelete()
    {
        return true;
    }


    /**
     * Get Grid/index data PAGINATED.
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
            ['id',
            ])
            ->paginate($per_page);
    }

    /**
     * Find by ID, sanitize the ID first.
     *
     * @param $id
     * @return Law or null
     */
    static public function sanitizeAndFind($id)
    {
        return self::findById(intval($id));
    }



    /**
     * Create base query to be used by Grid, Download, and PDF.
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

        $query = self::select($columns)
            ->orderBy($column, $direction);

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        return $query;
    }

    /**
     * Get export/Excel/download data query to send to Excel download library.
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

            foreach ($records as $rec) {
                $data[] = ['id' => $rec['id'], 'name' => $rec['name']];
            }

            return $data;
        }

    }

    static public function findById($id, $version_status = LawVersion::APPROVED, $date = null)
    {

        $query = LawVersion::baseFindQuery();
        $query->where('laws.id', $id);

        if ($version_status) {
            $version_status = !is_array($version_status) ? [$version_status] : $version_status;
            $query->whereIn('version_status', $version_status);
        }

        if ($date) {
            $query->whereRaw("'$date' between law_versions.start_date and law_versions.end_date");
        } else {
            $query->where('end_date', null);
        }

        return $query->first();
    }

    static public function getCharges($id)
    {
        $recs = Charge::with(['conviction:id,case_number,name,applicant_id', 'conviction.applicant:id,name'])->where('id', $id)->get();
        info(print_r($recs->toArray(), true));

        return $recs;
    }


}
