<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Conviction;
use App\Charge;

class ConvictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Conviction::all();
    }

    public function indexByClient(Request $request, $applicant_id)
    {
        $convictions = Conviction::where('applicant_id',$applicant_id)->get();

        foreach ( $convictions AS $i => $conviction) {
            $conviction_id = $conviction->id;
            $charges = Charge::where('conviction_id',$conviction_id)->get();
            if ($charges->count() > 0) {
                $convictions[$i]['charges'] = $charges;
            }
        }


        return $convictions;

    }

    public function add(Request $request, $applicant_id)
    {
        info("convictions::add($applicant_id)");
        info(print_r($request->toArray(),true));

        $data = $request->all();
        $data['applicant_id'] = $applicant_id;


        $conviction =  Conviction::create($data);
        return $conviction->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Conviction::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Conviction::find($id);
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
        $Conviction = Conviction::findOrFail($id);
        $Conviction->update($request->all());

        return $Conviction;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Conviction::find($id)->delete();
        Charge::where('conviction_id',$id)->delete();


        return 204;
    }
}
