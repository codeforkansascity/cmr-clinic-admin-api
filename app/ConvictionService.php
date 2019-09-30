<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ConvictionService extends Pivot
{
    protected $fillable = ['name'];
}
