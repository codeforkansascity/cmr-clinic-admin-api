<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordSignature;

class Statute extends Model
{

    use SoftDeletes;
    use RecordSignature;


    CONST ELIGIBLE = '1';
    CONST INELIGIBLE = '2';
    CONST POSSIBLY = '3';
    CONST UNDETERMINED = '4';
    const ELIGIBLITY_STATUSES = [
        self::ELIGIBLE,
        self::INELIGIBLE,
        self::POSSIBLY,
        self::UNDETERMINED,
    ];

    /**
     * fillable - attributes that can be mass-assigned
     */
    protected $fillable = [
        'id',
        'number',
        'name',
        'note',
        'statutes_eligibility_id',
        'deleted_at',
    ];

    protected $hidden = [
        'active',
        'created_by',
        'modified_by',
        'purged_by',
        'created_at',
        'updated_at',
    ];

    public function charge()
    {
        return $this->hasMany(Charge::class);
    }

    public function statutes_eligibility() {
        return $this->belongsTo(StatutesEligibility::class);
    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'comments');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function histories()
    {
        return $this->morphMany(History::class, 'historyable');
    }

    public function saveHistory($request)
    {

        $this->histories()->create([
            'old' => collect($this->getOriginal())->only($this->fillable),
            'new' => $request->only($this->fillable),
            'user_id' => auth()->user() ? auth()->user()->id : 0,
            'reason_for_change' => $request->reason_for_change ?? null,
        ]);
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

    public function getCharges($id) {
        $recs = \App\Charge::with(['conviction:id,case_number,name,client_id','conviction.client:id,name'])->where('statute_id', $id)->get();
        info(print_r($recs->toArray(),true));
        return $recs;

    }

    public function canDelete()
    {

        $count = \App\Charge::select('id')->whereNotNull('statute_id')->count();
        info(__METHOD__ . " count=$count|");
        return !$count;

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
        $keyword = '',
        $eligibility_id = 0)
    {
        return self::buildBaseGridQuery($column, $direction, $keyword, $eligibility_id,
            ['statutes.id as id',
                'statutes.number as number',
                'statutes.name as name',
                'statutes.note as note',
                'statutes_eligibilities.name AS eligible',
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
        $eligibility_id = 0,
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

        if ($column == 'eligible') {
            $column = 'statutes_eligibilities.name';
        }

        $query = Statute::select($columns)
            ->orderBy($column, $direction);

        if ($keyword) {
            $query->where('statutes.name', 'like', '%' . $keyword . '%');
            $query->orWhere('statutes.number', 'like', '%' . $keyword . '%');
        }

        if ($eligibility_id) {
            $query->where('statutes.statutes_eligibility_id', $eligibility_id);
        }

        $query->leftJoin('statutes_eligibilities', 'statutes.statutes_eligibility_id', '=', 'statutes_eligibilities.id');
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
        $eligibility_id = 0,
        $columns = '*'
    )
    {

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $keyword");

        return self::buildBaseGridQuery($column, $direction, $keyword, $eligibility_id, $columns);

    }

    static function pdfDataQuery(
        $column,
        $direction,
        $keyword = '',
        $eligibility_id = 0,
        $columns = '*')
    {

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $keyword");

        return self::buildBaseGridQuery($column, $direction, $keyword, $eligibility_id, $columns);

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
