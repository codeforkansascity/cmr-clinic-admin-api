<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatuteIndexRequest;
use App\Statute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StatuteApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(StatuteIndexRequest $request)
    {
        $page = $request->get('page', '1');                // Pagination looks at the request
        //    so not quite sure if we need this
        $column = $request->get('column', 'Name');
        $direction = $request->get('direction', '-1');
        $keyword = $request->get('keyword', '');
        $eligibility_id = $request->get('eligibility_id', '');

        // Save the search parameters so we can remember when we go back to the index
        //   The page is being done by Laravel
        session([
            'statute_page' => $page,
            'statute_column' => $column,
            'statute_direction' => $direction,
            'statute_keyword' => $keyword,
            'eligibility_id' => $eligibility_id,
        ]);

        $keyword = $keyword != 'null' ? $keyword : '';
        $column = $column ? mb_strtolower($column) : 'name';

        return Statute::indexData(10, $column, $direction, $keyword, $eligibility_id);
    }

    /**
     * Returns "options" for HTML select.
     * @return array
     */
    public function getOptions()
    {
        return Statute::getOptions();
    }

    public function get($id)
    {
        return Statute::with('statutes_eligibility', 'superseded')->find(intval($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
