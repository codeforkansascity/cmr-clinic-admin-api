<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cms_matter_number)
    {
       $client = Client::where('cms_matter_number', $cms_matter_number)
            ->with(['conviction', 'conviction.charge', 'assignment', 'step'])
            ->first();

        if(!$client) {
            abort(404, 'Client Not Found.');
        }

        $can_edit = auth()->user()->can('client edit');
        $can_delete = auth()->user()->can('client delete');
        return view('client.show', compact('client','can_edit', 'can_delete'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cms_matter_number)
    {
        if(!auth()->user()->can('client edit')) abort(401, 'Unauthorized');

        $client = Client::where('cms_matter_number', $cms_matter_number)
            ->with(['conviction', 'conviction.charge', 'assignment', 'step'])
            ->first();

        if(!$client) {
            abort(404, 'Client Not Found.');
        }

        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
