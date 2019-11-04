<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordSignature;

class StatutesEligibility extends Model
{

    use SoftDeletes;
    use RecordSignature;

    /**
     * fillable - attributes that can be mass-assigned
     */
    protected $fillable = [
            'id',
            'name',
            'sequence',
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
        $count = \App\Statute::select('id')->whereNotNull('statutes_eligibility_id')->count();
        info(__METHOD__ . " count=$count|");
        return !$count;
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
