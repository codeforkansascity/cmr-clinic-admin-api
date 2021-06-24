<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var array
     */
    protected $casts = [
        'old' => 'json',
        'new' => 'json',
    ];

    protected $appends = ['difference'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function historyable()
    {
        return $this->morphTo('historyable');
    }

    public function getDifferenceAttribute()
    {
        return $this->diff();
    }

    /**
     * @return array
     *  Example
     * "sentence" => [
     *       "old" => "10000 days",
     *       "new" => "10 1/2 days",
     *       ],
     */
    public function diff()
    {
        $diff = [];
        if ($this->old && $this->new) {
            $diff['statute'] = $this->arrayDiff($this->new, $this->old);
            if(!empty($this->new['exceptions']) || !empty($this->old['exceptions'])) {
                $diff['exceptions'] = $this->exceptionsDiff($this->new['exceptions'] ?? [], $this->old['exceptions'] ?? []);
            }
        }

        return $diff;
    }

    private function arrayDiff($array1, $array2)
    {
        $skip_list = ['modified_by'];

        $diff = [];
        foreach ($array1 as $column => $value) {
            if(in_array($column, $skip_list)) continue;

            if (!is_array($value) && $value !== ($array2[$column] ?? null)) {
                $diff[$column] = ['old' => $array2[$column] ?? null, 'new' => $value];
            }
        }

        return $diff;
    }

    private function exceptionsDiff($array_new, $array_old)
    {
        $map_new=[];
        foreach ($array_new as $exception) {
            $map_new[$exception['id']] = $exception;
        }
        $map_old=[];
        foreach ($array_old as $exception) {
            $map_old[$exception['id']] = $exception;
        }

        $diff = [];
        foreach ($map_new as $id => $exception) {
            if(!isset($map_old[$id])) {
                $diff[$exception['short_name']] = [
                    'exception_name' => $exception['name'],
                    'section' => $exception['section'],
                    'action' => 'Added',
                    'note' => [
                        'old' => null,
                        'new' => $exception['pivot']['note'] ?? null
                    ]
                ];
            }
            if ($exception['pivot']['note'] ?? null !== data_get($map_old[$id], "pivot.note", null)) {
                $diff[$exception['short_name']] = [
                    'exception_name' => $exception['name'],
                    'section' => $exception['section'],
                    'action' => 'Changed',
                    'note' => [
                        'old' => $map_old['pivot']['note'] ?? null,
                        'new' => $exception['pivot']['note'] ?? null
                    ]
                ];
            }
        }

        // check for removed
        foreach ($map_old as $id => $exception) {
            if(!isset($map_new[$id])) {
                $diff[$exception['short_name']] = [
                    'exception_name' => $exception['name'],
                    'section' => $exception['section'],
                    'action' => 'Removed',
                    'note' => [
                        'old' => $exception['pivot']['note'] ?? null,
                        'new' => null
                    ]
                ];
            }
        }


        return $diff;
    }
}
