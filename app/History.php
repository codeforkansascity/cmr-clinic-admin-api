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
            $diff[] = $this->arrayDiff($this->new, $this->old);
            if(!empty($this->new['exceptions']) || !empty($this->old['exceptions'])) {
                $diff[] = $this->exceptionsDiff($this->new['exceptions'] ?? [], $this->old['exceptions'] ?? []);
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

    private function exceptionsDiff($array1, $array2)
    {

        $diff = [];
        foreach ($array1 as $column => $value) {

            if($array1[$column]['pivot']['note'] ?? null !== data_get($array2, "$column.pivot.note", null) ) {
                $diff[] = [
                    'exception_name' => $array1[$column]['name'],
                    'section' => $array1[$column]['section'],
                    [
                        'old' => $array1[$column]['pivot']['note'] ?? null,
                        'new' => $array2[$column]['pivot']['note'] ?? null
                    ]
                ];
            }

//            if (!is_array($value) && $value !== ($array2['pivot'][$column] ?? null)) {
//                $diff[$column] = ['old' => $array2['pivot'][$column] ?? null, 'new' => $value];
//            }
//            if (is_array($value)) {
//                // always exception
//                $resDeep = $this->arrayDiff($value, $array2['pivot'][$column] ?? null);
//                if ($resDeep) {
//                    dd($resDeep, $value);
//                    $resDeep['name'] = $value['name'];
//                    $diff[$column] = $resDeep;
//                }
//            }
        }

        return $diff;
    }
}
