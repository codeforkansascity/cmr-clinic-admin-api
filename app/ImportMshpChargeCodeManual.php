<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature;

class ImportMshpChargeCodeManual extends Model
{

    use RecordSignature;

    /**
     * fillable - attributes that can be mass-assigned
     */
    protected $fillable = [
            'id',
            'mshp_version_id',
            'cmr_law_number',
            'cmr_chapter',
            'cmr_charge_code_seq',
            'cmr_charge_code_fingerprintable',
            'cmr_charge_code_effective_year',
            'cmr_charge_code_ncic_category',
            'cmr_charge_code_ncic_modifier',
            'cmr_attempt',
            'charge_code',
            'ncic_mod',
            'state_mod',
            'description',
            'type_class',
            'dna',
            'sor',
            'roc',
            'case_type',
            'effective_date',
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
            [ 'id',
                    'mshp_version_id',
                    'charge_code',
                    'ncic_mod',
                    'state_mod',
                    'description',
                    'type_class',
                    'dna',
                    'sor',
                    'roc',
                    'cmr_attempt',
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

        $query = ImportMshpChargeCodeManual::select($columns)
            ->where('mshp_version_id', 2)
        ->orderBy($column, $direction);

        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('description', 'like', '%' . strtolower($keyword) . '%')
                    ->orWhere('charge_code', 'like', '%' . strtolower($keyword) . '%');
                    });

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
