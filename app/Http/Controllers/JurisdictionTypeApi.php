<?php

namespace App\Http\Controllers;

use App\Http\Requests\JurisdictionTypeIndexRequest;
use App\JurisdictionType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JurisdictionTypeApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(JurisdictionTypeIndexRequest $request)
    {
        $page = $request->get('page', '1');                // Pagination looks at the request
        //    so not quite sure if we need this
        $column = $request->get('column', 'Name');
        $direction = $request->get('direction', '-1');
        $keyword = $request->get('keyword', '');

        // Save the search parameters so we can remember when we go back to the index
        //   The page is being done by Laravel
        session([
            'jurisdiction_type_page' => $page,
            'jurisdiction_type_column' => $column,
            'jurisdiction_type_direction' => $direction,
            'jurisdiction_type_keyword' => $keyword,
        ]);

        $keyword = $keyword != 'null' ? $keyword : '';
        $column = $column ? mb_strtolower($column) : 'name';

        return JurisdictionType::indexData(10, $column, $direction, $keyword);
    }

    /**
     * Returns "options" for HTML select.
     * @return array
     */
    public function getOptions()
    {
        return JurisdictionType::getOptions();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name');

        $jurisdiction_type = JurisdictionType::create($data);

        return $jurisdiction_type;
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
