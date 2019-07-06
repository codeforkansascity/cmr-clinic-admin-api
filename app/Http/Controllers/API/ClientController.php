<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use App\Conviction;

class ClientController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        info(__METHOD__ );

        return Client::all();
    }

    /**
     * Display a listing of the resource with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_v1_0_1(Request $request)
    {

        info(__METHOD__ );

        $page = $request->get('page', '1');                // Pagination looks at the request
        //    so not quite sure if we need this
        $column = $request->get('column', 'Name');
        $direction = $request->get('direction', '-1');
        $keyword = $request->get('keyword', '');



        $keyword = $keyword != 'null' ? $keyword : '';
        $column = $column ? mb_strtolower($column) : 'name';


        return Client::indexData(10, $column, $direction, $keyword);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newClient = Client::create($request->all());
        return $newClient->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client =  Client::find($id);


        return $client;
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
        $client = Client::findOrFail($id);
        $client->update($request->all());

        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::find($id)->delete();

        return 204;
    }
}
