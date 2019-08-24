<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $guarded = [];
    protected $casts = [
        'old' => 'json',
        'new' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historyable()
    {
        return $this->morphTo('historyable');
    }
}
