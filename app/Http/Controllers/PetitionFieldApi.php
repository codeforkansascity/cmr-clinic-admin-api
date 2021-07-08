<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetitionFieldFormRequest;
use App\Http\Requests\PetitionFieldIndexRequest;
use App\PetitionField;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PetitionFieldApi extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(PetitionFieldIndexRequest $request)
    {

        $page = $request->get('page', '1');                // Pagination looks at the request
        //    so not quite sure if we need this
        $column = $request->get('column', 'Name');
        $direction = $request->get('direction', '-1');
        $keyword = $request->get('keyword', '');

        // Save the search parameters so we can remember when we go back to the index
        //   The page is being done by Laravel
        session([
            'petition_field_page' => $page,
            'petition_field_column' => $column,
            'petition_field_direction' => $direction,
            'petition_field_keyword' => $keyword
        ]);

        $keyword = $keyword != 'null' ? $keyword : '';
        $column = $column ? mb_strtolower($column) : 'name';

        return PetitionField::indexData(10, $column, $direction, $keyword);
    }

    /**
     * Returns "options" for HTML select
     * @return array
     */
    public function getOptions()
    {

        return PetitionField::getOptions();
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
    public function show(PetitionFieldFormRequest $request)
    {
        $query = PetitionField::select('id', 'value')
            ->where('name', '=', $request->name)
            ->where('applicant_id', $request->applicant_id)
            ->where('petition_number', $request->petition_number);

        info(print_r($request->all(), true));
        info(print_r($query->toSql(), true));

        $data = $query->first();

        info('--11---');
        info(print_r($data, true));
        info('--22---');

        if ($data) {
            return response()->json([
                'message' => 'Found',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not Found xx'
            ], 404);
        }
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
