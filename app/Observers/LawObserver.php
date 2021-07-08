<?php

namespace App\Observers;

use App\Law;

class LawObserver
{
    protected $request;

    public function __construct()
    {
        $this->request = request();
    }

    /**
     * Handle the charge "created" event.
     *
     * @param Law $model
     * @return void
     */
    public function created(Law $model)
    {
        $model->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the charge "updated" event.
     *
     * @param Law $model
     * @return void
     */
    public function updated(Law $model)
    {
        $model->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the charge "deleted" event.
     *
     * @param Law $model
     * @return void
     */
    public function deleting(Law $model)
    {

//        $user = \Auth::User();
//        if ( $user ) {
//            $model->purged_by = $user->id;
//        } else {
//            $model->purged_by = -1;
//        }
//        $model->save();
    }

    /**
     * Handle the charge "deleted" event.
     *
     * @param Law $model
     * @return void
     */
    public function deleted(Law $model)
    {
        $model->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the charge "restored" event.
     *
     * @param Law $model
     * @return void
     */
    public function restored(Law $model)
    {
        //
    }

    /**
     * Handle the charge "force deleted" event.
     *
     * @param Law $model
     * @return void
     */
    public function forceDeleted(Law $model)
    {
        //
    }
}
