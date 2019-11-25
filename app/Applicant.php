<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordSignature;

class Applicant extends Model
{

    use SoftDeletes;
    use RecordSignature;

    /**
     * fillable - attributes that can be mass-assigned
     */
    protected $fillable = [
        'id',
        'name',
        'phone',
        'email',
        'sex',
        'race',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'license_number',
        'license_issuing_state',
        'previous_expungements',
        'previous_felony_expungements',
        'previous_misdemeanor_expungements',
        'notes',
        'external_ref',
        'any_pending_cases',
        'deleted_at',
        'status_id',
        'dob',
        'license_expiration_date',
        'cms_client_number',
        'cms_matter_number',
        'assignment_id',
        'step_id',
    ];

    protected $hidden = [
        'active',
        'created_by',
        'modified_by',
        'purged_by',
        'created_at',
        'updated_at',
    ];


    public function assignment()
    {
        return $this->hasOne('App\Assignment', 'id', 'assignment_id');
    }

    public function step()
    {
        return $this->hasOne('App\Step', 'id', 'step_id');
    }

    public function status()
    {
        return $this->hasOne('App\Status', 'id', 'status_id');
    }

    public function conviction()
    {
        return $this->hasMany('App\Conviction');

    }

    public function histories()
    {
        return $this->morphMany(History::class, 'historyable');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($tbl) { // before delete() method call this
            foreach ($tbl->conviction()->get() as $rec) {
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
     * @param $status_filter
     * @return mixed
     */
    static function indexData(
        $per_page,
        $column,
        $direction,
        $keyword = '',
        $status_filter = -1)
    {
        \DB::connection()->enableQueryLog();

        $ret = self::buildBaseGridQuery($column, $direction, $keyword, $status_filter,
            ['applicants.id',
                'applicants.name as applicant_name',
                'applicants.dob',
                'applicants.notes',
                'applicants.cms_client_number',
                'users.name AS assigned_to',
                'statuses.name AS status_name'
            ])
            ->paginate($per_page);


        $query = \DB::getQueryLog();
        $lastQuery = end($query);

        info(print_r($lastQuery, true));


        return $ret;
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
        $status_filter = -1,
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

        $column = $column == 'name' ? 'applicant_name' : $column;

        $query = Applicant::select($columns)
            ->leftJoin('users', 'applicants.assignment_id', 'users.id')
            ->leftJoin('statuses', 'applicants.status_id', 'statuses.id')
            ->orderBy($column, $direction);

        if ($keyword) {
            $query->where('applicants.name', 'like', '%' . $keyword . '%');
        }


        switch ($status_filter) {
            case -1:
            case 0:
                break;
            default:
                $query->where('applicants.status_id', intval($status_filter));
                break;

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

}
