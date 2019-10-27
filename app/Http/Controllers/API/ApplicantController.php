<?php

namespace App\Http\Controllers\API;

use App\Assignment;
use App\Step;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Applicant;
use App\Http\Requests\ApplicantFormRequest;
use App\Conviction;

class ApplicantController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        info(__METHOD__ );

        return Applicant::all();
    }

    /**
     * Display a listing of the resource with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_v1_0_1(Request $request)
    {

        if (!Auth::user()->can('applicant index')) {
            return response()->json([
                'error' => 'Not authorized'
            ], 403);
        }

        info(__METHOD__ );

        $page = $request->get('page', '1');                // Pagination looks at the request
        //    so not quite sure if we need this
        $column = $request->get('column', 'Name');
        $direction = $request->get('direction', '-1');
        $keyword = $request->get('keyword', '');

        $assigned_filter = $request->get('assigned_filter', -1);

        $status_filter = $request->get('status_filter', -1);



        $keyword = $keyword != 'null' ? $keyword : '';
        $column = $column ? mb_strtolower($column) : 'name';

        switch ($column) {
            case 'assigned_to':
                $column = 'users.name';
                break;
            default:
                $column = 'applicant.' . $column;
                break;

        }


        return Applicant::indexData(10, $column, $direction, $keyword, $assigned_filter, $status_filter);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newApplicant = Applicant::create($request->all());
        return $newApplicant->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $applicant =  Applicant::with('assignment','assignment.user','step', 'step.status')->find($id);
        $applicant =  Applicant::find($id);


        return $applicant;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicantFormRequest $request, $id)
    {
        $applicant = Applicant::with('assignment','assignment.user','step', 'step.status')->findOrFail($id);
        $user = Auth::user();
        $user_id = $user->id;

        $all_fields = $request->all();

        if (!$applicant->step || ($applicant->step->status_id != $request->status_id)) {

                $step = Step::create([
                    'applicant_id' => intval($id),
                    'status_id' => $request->status_id,
                    'created_by' => $user_id,
                    'modified_by' => $user_id
                ]);

                $all_fields['step_id'] = $step->id;

        }

        if ($applicant->assignment_id != $request->assignment_id) {

            Assignment::create([
                'applicant_id' => intval($id),
                'user_id' => $request->assignment_id,
                'created_by' => $user_id,
                'modified_by' => $user_id
            ]);

        }




        $applicant->update($all_fields);

        return $applicant;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Applicant::find($id)->delete();

        return 204;
    }
}
