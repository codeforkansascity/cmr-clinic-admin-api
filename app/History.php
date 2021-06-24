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
            return $this->arrayDiff($this->new, $this->old);
        }

        return $diff;
    }

    private function arrayDiff($array1, $array2)
    {
        $skip_list = ['modified_by'];

        $diff = [];
        foreach ($array1 as $column => $value) {
            if(in_array($column, $skip_list)) continue;

            if (is_array($value)) {
                $resDeep = $this->arrayDiff($value, $array2[$column] ?? null);
                if ($resDeep) {
                    $diff[$column] = $resDeep;
                }
            } elseif ($value !== ($array2[$column] ?? null)) {
                $diff[$column] = ['old' => $array2[$column] ?? null, 'new' => $value];
            }
        }

        return $diff;
    }
}
