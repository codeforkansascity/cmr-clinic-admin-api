<?php

namespace App\Observers;

use App\Charge;

class ChargeObserver
{
    /**
     * Handle the charge "created" event.
     *
     * @param  \App\Charge  $charge
     * @return void
     */
    public function created(Charge $charge)
    {
        //
    }

    /**
     * Handle the charge "updated" event.
     *
     * @param  \App\Charge  $charge
     * @return void
     */
    public function updated(Charge $charge)
    {
        $charge->saveHistory(request());
    }

    /**
     * Handle the charge "deleted" event.
     *
     * @param  \App\Charge  $charge
     * @return void
     */
    public function deleted(Charge $charge)
    {
        //
    }

    /**
     * Handle the charge "restored" event.
     *
     * @param  \App\Charge  $charge
     * @return void
     */
    public function restored(Charge $charge)
    {
        //
    }

    /**
     * Handle the charge "force deleted" event.
     *
     * @param  \App\Charge  $charge
     * @return void
     */
    public function forceDeleted(Charge $charge)
    {
        //
    }
}
