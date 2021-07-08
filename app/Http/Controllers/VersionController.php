<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class VersionController extends Controller
{
    /**
     * Display the specified resource.
     *d.
     * @param int $id
     * @return Response
     */
    public function show()
    {
        return view('version.show');

    }
}
