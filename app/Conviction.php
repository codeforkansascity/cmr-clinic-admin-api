<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordSignature;
use Illuminate\Notifications\Notifiable;

class Conviction extends Model
{

    use SoftDeletes;
    use RecordSignature;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'applicant_id',
        'name',
        'arrest_date',
        'case_number',
        'agency',
        'court_name',
        'court_city_county',
        'name_of_judge',
        'your_name_in_case',
        'release_status',
        'release_date',
        'judge',
        'record_name',
        'notes',
        'date_of_charge',
        'arresting_agency',
        'date_of_disposition',
        'sis',
        'source',
        'created_by',
        'modified_by',
    ];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }

    public function charge()
    {
        return $this->hasMany('App\Charge');
    }

    public function histories()
    {
        return $this->morphMany(History::class, 'historyable');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->using(ConvictionService::class)
            ->withPivot(['name']);
    }

    public function sources()
    {
        return $this->belongsToMany(DataSource::class, 'conviction_source', 'conviction_id', 'data_source_id', 'id', 'id');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($tbl) { // before delete() method call this
            foreach ($tbl->charge()->get() as $rec) {
                $rec->delete();
            }
        });
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
            ['id',
                'name',
                'notes',
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

        $query = Conviction::select($columns)
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

    public function saveHistory($request, $action = 'updated')
    {
        $data = [
            'user_id' => auth()->user()->id ?? 1,
            'reason_for_change' => $request->reason_for_change ?? null,
            'action' => $action
        ];

        /*
         * We only save the values listed in fillable for old and new
         */
        /// if not created add old values
        if ($action !== 'created') {
            $data['old'] = collect($this->getOriginal())->only($this->fillable);
        }
        /// if not deleted add new values
        if ($action !== 'deleted') {
            $data['new'] = $request->only($this->fillable);
        }

        return $this->histories()->create($data);
    }

//
//    public function saveHistory($request)
//    {
//        return $this->histories()->create([
//            'old' => $this->only($this->fillable),
//            'new' => $request->only($this->fillable),
//            'user_id' => auth()->user()->id,
//            'reason_for_change' => $request->reason_for_change ?? null,
//        ]);
//    }
}
