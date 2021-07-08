<?php

namespace App\Http\Controllers;

use App\CdlStatus;

class CdlStatusApi extends Controller
{

    /**
     * Returns "options" for HTML select.
     * @return array
     */
    public function getOptions()
    {
        return CdlStatus::getOptions();
    }


}
