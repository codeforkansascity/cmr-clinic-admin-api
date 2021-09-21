<?php

namespace App;

use App\Traits\RecordSignature;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;

class Statute extends Model
{
    use SoftDeletes;
    use RecordSignature;

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
        'number',
        'name',
        'common_name',
        'note',
        'statutes_eligibility_id',
        'superseded_id',
        'superseded_on',
        'deleted_at',
        'jurisdiction_id',
        'same_as_id',
        'blocks_time'
    ];

    protected $hidden = [
        'active',
        'created_by',
        'modified_by',
        'purged_by',
        'created_at',
        'updated_at',
    ];

    public function superseded()
    {
        return $this->belongsTo(self::class);
    }

    public function jurisdiction()
    {
        return $this->belongsTo(Jurisdiction::class)->with('type');
    }

    public function charge()
    {
        return $this->hasMany(Charge::class);
    }
    public function statute_exceptions()
    {
        return $this->hasMany(StatuteException::class)->with('exception','exception_code');
    }

    public function exceptions()
    {
        return $this->belongsToMany(\App\Exception::class,'statute_exceptions')->withPivot('note');
    }



    public function statutes_eligibility()
    {
        return $this->belongsTo(StatutesEligibility::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'comments');
    }

    /**
     * @return MorphMany
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
        } catch (Exception $e) {
            info(__METHOD__.' line: '.__LINE__.':  '.$e->getMessage());
            throw new Exception($e->getMessage());
        } catch (QueryException $e) {
            info(__METHOD__.' line: '.__LINE__.':  '.$e->getMessage());
            throw new Exception($e->getMessage());
        }

        return true;
    }

    public function getCharges($id)
    {
        $recs = Charge::with(['conviction:id,case_number,name,applicant_id', 'conviction.applicant:id,name'])->where('statute_id', $id)->get();
        info(print_r($recs->toArray(), true));

        return $recs;
    }

    public function canDelete()
    {
        $count = Charge::select('id')->whereNotNull('statute_id')->count();
        info(__METHOD__." count=$count|");

        return ! $count;
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
    public static function indexData(
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
                'jurisdiction_types.name AS jurisdiction_type',
                'jurisdictions.name AS jurisdiction',

            ])
            ->paginate($per_page);
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
    public static function buildBaseGridQuery(
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

        $query = self::select($columns)
            ->orderBy($column, $direction);

        if ($keyword) {
            $query->where('statutes.name', 'like', '%'.$keyword.'%');
            $query->orWhere('statutes.number', 'like', '%'.$keyword.'%');
        }

        if ($eligibility_id) {
            $query->where('statutes.statutes_eligibility_id', $eligibility_id);
        }

        $query->leftJoin('statutes_eligibilities', 'statutes.statutes_eligibility_id', '=', 'statutes_eligibilities.id');
        $query->leftJoin('jurisdictions', 'statutes.jurisdiction_id', '=', 'jurisdictions.id');
        $query->leftJoin('jurisdiction_types', 'jurisdictions.jurisdiction_type_id', '=', 'jurisdiction_types.id');

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
    public static function exportDataQuery(
        $column,
        $direction,
        $keyword = '',
        $eligibility_id = 0,
        $columns = '*'
    ) {
        info(__METHOD__.' line: '.__LINE__." $column, $direction, $keyword");

        return self::buildBaseGridQuery($column, $direction, $keyword, $eligibility_id, $columns);
    }

    public static function pdfDataQuery(
        $column,
        $direction,
        $keyword = '',
        $eligibility_id = 0,
        $columns = '*')
    {
        info(__METHOD__.' line: '.__LINE__." $column, $direction, $keyword");

        return self::buildBaseGridQuery($column, $direction, $keyword, $eligibility_id, $columns);
    }

    /**
     * Get "options" for HTML select tag.
     *
     * If flat return an array.
     * Otherwise, return an array of records.  Helps keep in proper order durring ajax calls to Chrome
     */
    public static function getOptions($flat = false)
    {
        $thisModel = new static;

        $records = $thisModel::select('id',
            'name')
            ->orderBy('name')
            ->get();

        if (! $flat) {
            return $records;
        } else {
            $data = [];

            foreach ($records as $rec) {
                $data[] = ['id' => $rec['id'], 'name' => $rec['name']];
            }

            return $data;
        }
    }

    public function scopeWithEligibility($builder)
    {
        // check if the selects are loaded if not load them
        if (is_null($builder->getQuery()->columns)) {
            $builder->select('statutes.*');
        }

        // build subquery to join eligibility status and select name as eligibility
        $query = StatutesEligibility::select('name')
            ->whereColumn('statutes.statutes_eligibility_id', 'statutes_eligibilities.id');

        return $builder->selectSub($query->limit(1), 'eligibility');
    }

    public function scopeWithSuperseded($query)
    {
        $query->withEligibility()
            ->with([
                'superseded' => function ($q) {
                    $q->withEligibility();
                },
            ]);
    }

    public function scopeWithJurisdictionType($builder)
    {
        // check if the selects are loaded if not load them
        if (is_null($builder->getQuery()->columns)) {
            $builder->select('statutes.*');
        }

        // build subquery to join eligibility status and select name as eligibility
        $query = Jurisdiction::select('jurisdiction_types.name')
            ->whereColumn('statutes.jurisdiction_id', 'jurisdictions.id')
            ->join('jurisdiction_types', 'jurisdictions.jurisdiction_type_id', 'jurisdiction_types.id');

        return $builder->selectSub($query->limit(1), 'jurisdiction_type');
    }

    public function withSupersededRecursive($query)
    {

        /**
         * with recursive cte (id,  superseded_id) as (
                    select     id,
                    superseded_id
                    from       statutes
                    where      id = 220
                    union all
                    select     p.id,
                    p.superseded_id
                    from       statutes p
                    inner join cte
                    on cte.superseded_id = p.id
                )
            select * from cte;
         */
    }

    public static function getIdByNumber($number,$jurisdiction_id) {
        $thisModel = new static;

        $statute =  $thisModel::select('id')
            ->where('number', $number)
            ->where('jurisdiction_id', $jurisdiction_id)
            ->first();

        return data_get($statute,'id',null);

    }
}
