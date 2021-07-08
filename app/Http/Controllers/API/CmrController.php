<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CmrRequest;
use App\Statute;
use App\StatuteException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class CmrController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(CmrRequest $request)
    {

        $validated = $request->validated();

        $number = $request->get('statute_number');

        if ($statute = $this->getStatute($number)) {
            $data = $statute->toJson(JSON_PRETTY_PRINT);
            return response($data, 200);
        } else {
            return response()->json([], 404);
        }


    }

    private function getStatute($number)
    {
        $data = Statute::select([
            'statutes.id AS id',
            DB::raw("CONCAT(statutes.number,' ', statutes.name) AS statute"),
            'statutes.common_name AS common_name',
            DB::raw("CONCAT(superseded.number,' ', superseded.name) AS superseded_statute"),
            'statutes.superseded_on',
            'statutes.blocks_time',
            'statutes_eligibilities.name as eligibility'
        ])
            ->leftJoin('statutes_eligibilities', 'statutes_eligibilities.id', '=', 'statutes.statutes_eligibility_id')
            ->leftJoin('statutes AS superseded', 'superseded.id', '=', 'statutes.superseded_id')
            ->where('statutes.number', $number)->first();

        if ($data) {
            $exceptions = StatuteException::select([
                DB::raw("CONCAT(exceptions.section,' ', exceptions.name) AS exception"),
                'short_name',
                'attorney_note',
                'dyi_note',
                'logic'
            ])
                ->leftJoin('exceptions', 'exceptions.id', '=', 'statute_exceptions.exception_id')
                ->where('statute_id', $data->id)
                ->get();

            if ($exceptions) {
                $data->exceptions = $exceptions;
            }
        }

        unset($data->id);

        return $data;
    }


}
