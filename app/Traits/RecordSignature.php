<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait RecordSignature
{


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->fillable[] = 'created_by';
            $user = \Auth::User();
            if ( $user ) {
                $model->created_by = $user->id;
            } else {
                $model->created_by = -1;
            }
        });

        static::updating(function ($model) {
            $model->fillable[] = 'modified_by';
            $user = \Auth::User();
            if ( $user ) {
                $model->modified_by = $user->id;
            } else {
                $model->modified_by = -1;
            }
        });

        static::deleting(function ($model) {
            $model->fillable[] = 'purged_by';

            $user = \Auth::User();
            if ( $user ) {
                $model->purged_by = $user->id;
            } else {
                $model->purged_by = -1;
            }

            $model->save();
        });

    }

}
