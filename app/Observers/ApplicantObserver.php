<?php

namespace App\Observers;

use App\Applicant;

class ApplicantObserver
{
    protected $request;
    public function __construct()
    {
        $this->request = request();
    }
    /**
     * Handle the applicant "created" event.
     *
     * @param  \App\Applicant  $applicant
     * @return void
     */
    public function created(Applicant $applicant)
    {
        $applicant->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the applicant "updated" event.
     *
     * @param  \App\Applicant  $applicant
     * @return void
     */
    public function updated(Applicant $applicant)
    {
        $applicant->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the applicant "deleted" event.
     *
     * @param  \App\Applicant  $applicant
     * @return void
     */
    public function deleted(Applicant $applicant)
    {
        $applicant->saveHistory($this->request, __FUNCTION__);
    }

    /**
     * Handle the applicant "restored" event.
     *
     * @param  \App\Applicant  $applicant
     * @return void
     */
    public function restored(Applicant $applicant)
    {
        //
    }

    /**
     * Handle the applicant "force deleted" event.
     *
     * @param  \App\Applicant  $applicant
     * @return void
     */
    public function forceDeleted(Applicant $applicant)
    {
        //
    }
}
