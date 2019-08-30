<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statute extends Model
{
    CONST INELIGIBLE = 'ineligible';
    CONST ELIGIBLE = 'eligible';
    CONST POSSIBLY = 'possibly';
    const ELIGIBLITY_STATUSES = [
        self::ELIGIBLE,
        self::INELIGIBLE,
        self::POSSIBLY,
    ];

    protected $fillable = [
        'number',
        'name',
        'eligible'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'comments');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function histories()
    {
        return $this->morphMany(History::class, 'historyable');
    }

    /**
     * @param $request
     */
    public function saveHistory($request)
    {
        $this->histories()->save([
            'old' => collect($this->getOriginal())->only($this->fillable),
            'new' => $request->only($this->fillable),
            'user_id' => auth()->user()->id,
            'reason_for_change' => $request->reason_for_change ?? null,
        ]);
    }
}
