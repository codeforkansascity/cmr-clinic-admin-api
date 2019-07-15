<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Status;

class StatusController extends Controller
{

    /**
     * Display a listing of the resource with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $page = $request->get('page', '1');                // Pagination looks at the request
        //    so not quite sure if we need this
        $column = $request->get('column', 'Name');
        $direction = $request->get('direction', '-1');
        $keyword = $request->get('keyword', '');

        $keyword = $keyword != 'null' ? $keyword : '';
        $column = $column ? mb_strtolower($column) : 'name';

        return Status::indexData(10, $column, $direction, $keyword);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newStatus = Status::create($request->all());
        return $newStatus->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status =  Status::find($id);

        return $status;
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
        $status = Status::findOrFail($id);
        $status->update($request->all());

        return $status;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Status::find($id)->delete();

        return 204;
    }
}
