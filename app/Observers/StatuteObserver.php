<?php

namespace App\Observers;

use App\Statute;

class StatuteObserver
{
    static $originalExceptions = [];


    /**
     * Handle the statute "created" event.
     *
     * @param  \App\Statute  $statute
     * @return void
     */
    public function created(Statute $statute)
    {

        if(request()) {
           $data = request();
        } else {
            $data = $statute;
            $data->reason_for_change = "New Record";
        }
        $statute->saveHistory($data);
    }

    public function updating(Statute $statute)
    {
        static::$originalExceptions = $statute->exceptions;
    }

    /**
     * Handle the statute "updated" event.
     *
     * @param  \App\Statute  $statute
     * @return void
     */
    public function updated(Statute $statute)
    {
        info('original exceptions', [static::$originalExceptions]);
        $statute->saveHistory(request(), static::$originalExceptions);

        static::$originalExceptions = [];
    }

    /**
     * Handle the statute "deleted" event.
     *
     * @param  \App\Statute  $statute
     * @return void
     */
    public function deleted(Statute $statute)
    {
        $statute->saveHistory(request());
    }

    /**
     * Handle the statute "restored" event.
     *
     * @param  \App\Statute  $statute
     * @return void
     */
    public function restored(Statute $statute)
    {
        //
    }

    /**
     * Handle the statute "force deleted" event.
     *
     * @param  \App\Statute  $statute
     * @return void
     */
    public function forceDeleted(Statute $statute)
    {
        //
    }
}
