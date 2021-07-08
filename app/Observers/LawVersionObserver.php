<?php

namespace App\Observers;

use App\LawVersion;

class LawVersionObserver
{
    protected $request;

    public function __construct()
    {
        $this->request = request();
    }

    /**
     * Handle the charge "created" event.
     *
     * @param LawVersion $model
     * @return void
     */
    public function created(LawVersion $model)
    {
        $model->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the charge "updated" event.
     *
     * @param LawVersion $model
     * @return void
     */
    public function updated(LawVersion $model)
    {
        $model->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the charge "deleted" event.
     *
     * @param LawVersion $model
     * @return void
     */
    public function deleting(LawVersion $model)
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
     * @param LawVersion $model
     * @return void
     */
    public function deleted(LawVersion $model)
    {
        $model->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the charge "restored" event.
     *
     * @param LawVersion $model
     * @return void
     */
    public function restored(LawVersion $model)
    {
        //
    }

    /**
     * Handle the charge "force deleted" event.
     *
     * @param LawVersion $model
     * @return void
     */
    public function forceDeleted(LawVersion $model)
    {
        //
    }
}
