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
        'new' => 'json'
    ];

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
            foreach ($this->new as $column => $value) {
                if($value !== $this->old[$column]) {
                    $diff[$column] = ['old' => $this->old[$column], 'new' => $value];
                }
            }
        }

        return $diff;
    }
}
