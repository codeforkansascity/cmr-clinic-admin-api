<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LawChapter extends Model
{
    protected $fillable = [
        'id',
        'jurisdiction_id',
        'chapter_number',
        'chapter_title',
    ];
}
