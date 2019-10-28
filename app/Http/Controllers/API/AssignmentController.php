<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Assignment;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Auth::user()->can('assignment index')) {  // TODO: add -> create
            return response()->json([
                'error' => 'Not authorized'
            ], 403);
        }
        return Assignment::all();
    }

    public function indexByClient(Request $request, $applicant_id)
    {

        if (!Auth::user()->can('assignment index')) {
            return response()->json([
                'error' => 'Not authorized'
            ], 403);
        }

        $assignments = Assignment::where('applicant_id',$applicant_id)->get();



        return $assignments;

    }

    public function add(Request $request, $applicant_id)
    {
        info("assignments::add($applicant_id)");
        info(print_r($request->toArray(),true));

        $data = $request->all();
        $data['applicant_id'] = $applicant_id;


        $assignment =  Assignment::create($data);
        return $assignment->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Assignment::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Assignment::find($id);
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
        $Assignment = Assignment::findOrFail($id);
        $Assignment->update($request->all());

        return $Assignment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Assignment::find($id)->delete();


        return 204;
    }
}
