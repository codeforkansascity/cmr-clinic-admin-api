<?php

namespace App\Http\Controllers\API;

use App\Charge;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Charge::all();
    }

    public function add(Request $request, $applicant_id, $conviction_id)
    {
        info("Charges::add($applicant_id");

        $data = $request->all();
        $data['conviction_id'] = $conviction_id;
        $charge = Charge::create($data);

        return $charge->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return Charge::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return Charge::find($id);
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
        $Charge = Charge::findOrFail($id);
        $Charge->update($request->all());

        return $Charge;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        Charge::find($id)->delete();

        return 204;
    }
}
