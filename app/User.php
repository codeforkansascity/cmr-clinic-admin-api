<?php

namespace App;

use App\Traits\RecordSignature;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// From crud generator:
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    use SoftDeletes;
    use RecordSignature;

    /**
     * fillable - attributes that can be mass-assigned.
     */
    protected $fillable = [
            'id',
            'name',
            'email',
            'active',
            'email_verified_at',
            'password',
            'remember_token',
        ];

    protected $hidden = [
        /*'created_by',
        'modified_by',
        'purged_by',*/
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function add($attributes, $selected_roles)
    {
        try {
            $this->fill($attributes);

            // Hash the pw
            $this->password = bcrypt($this->password);

            $this->save();
            $this->syncRoles($selected_roles);
        } catch (\Exception $e) {
            info(__METHOD__.' line: '.__LINE__.':  '.$e->getMessage());
            throw new \Exception($e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            info(__METHOD__.' line: '.__LINE__.':  '.$e->getMessage());
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    public function canDelete()
    {
        return false;
    }

    /**
     * Get Grid/index data PAGINATED.
     *
     * @param $per_page
     * @param $column
     * @param $direction
     * @param string $keyword
     * @return mixed
     */
    public static function indexData(
        $per_page,
        $column,
        $direction,
        $keyword = '')
    {
        return self::buildBaseGridQuery($column, $direction, $keyword,
            ['id',
                    'name',
                    'email',
                    'active',
            ])
        ->paginate($per_page);
    }

    /**
     * Create base query to be used by Grid, Download, and PDF.
     *
     * NOTE: to override the select you must supply all fields, ie you cannot add to the
     *       fields being selected.
     *
     * @param $column
     * @param $direction
     * @param string $keyword
     * @param string|array $columns
     * @return mixed
     */
    public static function buildBaseGridQuery(
        $column,
        $direction,
        $keyword = '',
        $columns = '*')
    {
        // Map sort direction from 1/-1 integer to asc/desc sql keyword
        switch ($direction) {
            case '1':
                $direction = 'desc';
                break;
            case '-1':
                $direction = 'asc';
                break;
            default:
                $direction = 'asc';
                break;
        }

        $query = self::select($columns)
            ->orderBy($column, $direction);
        $query->orderBy('name', 'ASC'); // Secondary sort criteria of name

        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%'.$keyword.'%')
                    ->orWhere('email', 'like', '%'.$keyword.'%');
            });
        }

        return $query;
    }

    /**
     * Get export/Excel/download data query to send to Excel download library.
     *
     * @param $per_page
     * @param $column
     * @param $direction
     * @param string $keyword
     * @return mixed
     */
    public static function exportDataQuery(
        $column,
        $direction,
        $keyword = '',
        $columns = '*')
    {
        info(__METHOD__.' line: '.__LINE__." $column, $direction, $keyword");

        return self::buildBaseGridQuery($column, $direction, $keyword, $columns);
    }

    public static function pdfDataQuery(
            $column,
            $direction,
            $keyword = '',
            $columns = '*')
    {
        info(__METHOD__.' line: '.__LINE__." $column, $direction, $keyword");

        return self::buildBaseGridQuery($column, $direction, $keyword, $columns);
    }

    /**
     * Get "options" for HTML select tag.
     *
     * If flat return an array.
     * Otherwise, return an array of records.  Helps keep in proper order durring ajax calls to Chrome
     */
    public static function getOptions($flat = false)
    {
        $thisModel = new static;

        $records = $thisModel::select('id',
            'name')
            ->orderBy('name')
            ->get();

        if (! $flat) {
            return $records;
        } else {
            $data = [];

            foreach ($records as $rec) {
                $data[] = ['id' => $rec['id'], 'name' => $rec['name']];
            }

            return $data;
        }
    }

    /**
     * Get "options" for HTML select tag.
     *
     * If flat return an array.
     * Otherwise, return an array of records.  Helps keep in proper order durring ajax calls to Chrome
     */
    public static function getAssigneeOptions($flat = false)
    {
        $thisModel = new static;

        $records = $thisModel::select('id',
            'name')
            ->orderBy('name')
            ->get();

        if (! $flat) {
            return $records;
        } else {
            $data = [];

            foreach ($records as $rec) {
                $data[] = ['id' => $rec['id'], 'name' => $rec['name']];
            }

            return $data;
        }
    }

    /**
     * Get "options" for HTML select tag.
     *
     * If flat return an array.
     * Otherwise, return an array of records.  Helps keep in proper order durring ajax calls to Chrome
     */
    public static function getRoleOptions($flat = false)
    {
        $thisModel = new static;

        $records = \App\Role::select('id',
            'name')
            ->orderBy('name')
            ->get();

        if (! $flat) {
            $data = [];

            foreach ($records as $rec) {
                $data[] = ['id' => $rec['name'], 'name' => $rec['name']];
            }

            return $data;
        } else {
            $data = [];

            foreach ($records as $rec) {
                $data[] = ['id' => $rec['name'], 'name' => $rec['name']];
            }

            return $data;
        }
    }

    public function areRolesDirty($current_roles, $new_roles)
    {
        $roles_is_dirty = false;
        $old_roles = [];
        foreach ($current_roles as $user_role) {
            $old_roles[] = $user_role->name;
        }
        sort($new_roles);
        sort($old_roles);
        if ($new_roles != $old_roles) {
            $roles_is_dirty = true;
        }

        return $roles_is_dirty;
    }
}
