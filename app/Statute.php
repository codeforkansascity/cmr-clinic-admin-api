<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordSignature;

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

    use SoftDeletes;
    use RecordSignature;

    /**
     * fillable - attributes that can be mass-assigned
     */
    protected $fillable = [
            'id',
            'number',
            'name',
            'note',
            'eligible',
            'deleted_at',
        ];

    protected $hidden = [
        'active',
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
        } catch (\Exception $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    public function canDelete()
    {
        return true;
    }


    /**
     * Get Grid/index data PAGINATED
     *
     * @param $per_page
     * @param $column
     * @param $direction
     * @param string $keyword
     * @return mixed
     */
    static function indexData(
        $per_page,
        $column,
        $direction,
        $keyword = '')
    {
        return self::buildBaseGridQuery($column, $direction, $keyword,
            [ 'id',
                    'number',
                    'name',
                    'eligible',
            ])
        ->paginate($per_page);
    }




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
