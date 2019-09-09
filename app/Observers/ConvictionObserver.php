<?php

namespace App\Observers;

use App\Charge;

class ConvictionObserver
{
    /**
     * Handle the charge "created" event.
     *
     * @param  \App\Conviction  $charge
     * @return void
     */
    public function created(Conviction $charge)
    {
        //
    }

    /**
     * Handle the charge "updated" event.
     *
     * @param  \App\Conviction  $charge
     * @return void
     */
    public function updated(Conviction $charge)
    {
        $charge->saveHistory(request());
    }

    /**
     * Handle the charge "deleted" event.
     *
     * @param  \App\Conviction  $charge
     * @return void
     */
    public function deleted(Conviction $charge)
    {
        //
    }

    /**
     * Handle the charge "restored" event.
     *
     * @param  \App\Conviction  $charge
     * @return void
     */
    public function restored(Conviction $charge)
    {
        //
    }

    /**
     * Handle the charge "force deleted" event.
     *
     * @param  \App\Conviction  $charge
     * @return void
     */
    public function forceDeleted(Conviction $charge)
    {
        //
    }
}
