<?php

namespace App\Observers;

use App\Statute;

class StatuteObserver
{
    /**
     * Handle the statute "created" event.
     *
     * @param  \App\Statute  $statute
     * @return void
     */
    public function created(Statute $statute)
    {
        $statute->saveHistory(request());
    }

    /**
     * Handle the statute "updated" event.
     *
     * @param  \App\Statute  $statute
     * @return void
     */
    public function updated(Statute $statute)
    {
        $statute->saveHistory(request());

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
