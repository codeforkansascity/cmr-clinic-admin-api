<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Step;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Auth::user()->can('step index')) {  // TODO: add -> create
            return response()->json([
                'error' => 'Not authorized'
            ], 403);
        }
        return Step::all();
    }

    public function indexByClient(Request $request, $applicant_id)
    {

//        if (!Auth::user()->can('step index')) {
//            return response()->json([
//                'error' => 'Not authorized'
//            ], 403);
//        }

        $steps = Step::where('applicant_id',$applicant_id)->get();



        return $steps;

    }

    public function add(Request $request, $applicant_id)
    {
        info("steps::add($applicant_id)");
        info(print_r($request->toArray(),true));

        $data = $request->all();
        $data['applicant_id'] = $applicant_id;


        $step =  Step::create($data);
        return $step->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Step::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Step::find($id);
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
        $Step = Step::findOrFail($id);
        $Step->update($request->all());

        return $Step;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Step::find($id)->delete();


        return 204;
    }
}
