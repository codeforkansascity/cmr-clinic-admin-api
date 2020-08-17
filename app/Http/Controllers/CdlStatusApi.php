<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\CdlStatus;
use Illuminate\Http\Request;

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
