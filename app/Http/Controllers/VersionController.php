<?php

namespace App\Http\Controllers;

class VersionController extends Controller
{
    /**
     * Display the specified resource.
     *d.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('version.show');

    }
}
