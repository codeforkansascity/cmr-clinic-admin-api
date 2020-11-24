<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\QueryException;

class CdlStatus extends Model
{

    const YES = '1';
    const NO = '0';
    const UNKNOWN = '2';
    const CDL_STATUSES = [
        self::YES,
        self::NO,
        self::UNKNOWN,
    ];
    /**
     * fillable - attributes that can be mass-assigned.
     */
    protected $fillable = [
        'id',
        'name',
    ];

    protected $hidden = [

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
            info(__METHOD__.' line: '.__LINE__.':  '.$e->getMessage());
            throw new Exception($e->getMessage());
        } catch (QueryException $e) {
            info(__METHOD__.' line: '.__LINE__.':  '.$e->getMessage());
            throw new Exception($e->getMessage());
        }

        return true;
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
