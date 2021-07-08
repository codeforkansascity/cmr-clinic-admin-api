<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ConvictionService extends Pivot
{
    protected $fillable = ['name'];
}
