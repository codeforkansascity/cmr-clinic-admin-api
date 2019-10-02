<?php

namespace App\Observers;

use App\Charge;
use Illuminate\Support\Facades\Log;

class ChargeObserver
{
    protected $request;
    public function __construct()
    {
        $this->request = request();
    }

    /**
     * Handle the charge "created" event.
     *
     * @param  Charge  $charge
     * @return void
     */
    public function created(Charge $charge)
    {
        $charge->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the charge "updated" event.
     *
     * @param  Charge  $charge
     * @return void
     */
    public function updated(Charge $charge)
    {
        $charge->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the charge "deleted" event.
     *
     * @param  Charge  $charge
     * @return void
     */
    public function deleting(Charge $charge)
    {

//        $user = \Auth::User();
//        if ( $user ) {
//            $charge->purged_by = $user->id;
//        } else {
//            $charge->purged_by = -1;
//        }
//        $charge->save();

    }

    /**
     * Handle the charge "deleted" event.
     *
     * @param  Charge  $charge
     * @return void
     */
    public function deleted(Charge $charge)
    {
        $charge->saveHistory($this->request, __FUNCTION__);

    }

    /**
     * Handle the charge "restored" event.
     *
     * @param  Charge  $charge
     * @return void
     */
    public function restored(Charge $charge)
    {
        //
    }

    /**
     * Handle the charge "force deleted" event.
     *
     * @param  Charge  $charge
     * @return void
     */
    public function forceDeleted(Charge $charge)
    {
        //
    }
}
