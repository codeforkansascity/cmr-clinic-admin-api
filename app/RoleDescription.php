<?php

namespace App;

use App\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleDescription extends Model
{
    use RecordSignature;
    use SoftDeletes;
    use RecordSignature;

    /**
     * fillable - attributes that can be mass-assigned.
     */
    protected $fillable = [
            'id',
            'role_id',
            'role_name',
            'name',
            'description',
            'sequence',
            'roles_that_can_assign',
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

    public function add($attributes)
    {
        try {
            $this->fill($attributes)->save();
        } catch (\Exception $e) {
            info(__METHOD__.' line: '.__LINE__.':  '.$e->getMessage());
            throw new \Exception($e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            info(__METHOD__.' line: '.__LINE__.':  '.$e->getMessage());
            throw new \Exception($e->getMessage());
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
    public static function indexData(
        $per_page,
        $column,
        $direction,
        $keyword = '')
    {
        return self::buildBaseGridQuery($column, $direction, $keyword,
            ['id',
                    'name',
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
            $query->where('name', 'like', '%'.$keyword.'%');
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
    public static function exportDataQuery(
        $column,
        $direction,
        $keyword = '',
        $columns = '*')
    {
        info(__METHOD__.' line: '.__LINE__." $column, $direction, $keyword");

        return self::buildBaseGridQuery($column, $direction, $keyword, $columns);
    }

    public static function pdfDataQuery(
            $column,
            $direction,
            $keyword = '',
            $columns = '*')
    {
        info(__METHOD__.' line: '.__LINE__." $column, $direction, $keyword");

        return self::buildBaseGridQuery($column, $direction, $keyword, $columns);
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
}
