<?php

namespace App\Observers;

use App\Conviction;

class ConvictionObserver
{
    protected $request;

    public function __construct()
    {
        $this->request = request();
    }

    /**
     * Handle the conviction "created" event.
     *
     * @param Conviction $conviction
     * @return void
     */
    public function created(Conviction $conviction)
    {
        $conviction->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the conviction "updated" event.
     *
     * @param Conviction $conviction
     * @return void
     */
    public function updated(Conviction $conviction)
    {
        $conviction->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the conviction "deleted" event.
     *
     * @param Conviction $conviction
     * @return void
     */
    public function deleted(Conviction $conviction)
    {
        $conviction->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the conviction "restored" event.
     *
     * @param Conviction $conviction
     * @return void
     */
    public function restored(Conviction $conviction)
    {
        //
    }

    /**
     * Handle the conviction "force deleted" event.
     *
     * @param Conviction $conviction
     * @return void
     */
    public function forceDeleted(Conviction $conviction)
    {
        //
    }
}
