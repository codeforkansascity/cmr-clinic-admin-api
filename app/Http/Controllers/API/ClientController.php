<?php

namespace App\Http\Controllers\API;

use App\Assignment;
use App\Step;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Http\Requests\ApplicantFormRequest;
use App\Conviction;

class ClientController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        info(__METHOD__ );

        return Client::all();
    }

    /**
     * Display a listing of the resource with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_v1_0_1(Request $request)
    {

        if (!Auth::user()->can('client index')) {
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
                $column = 'clients.' . $column;
                break;

        }


        return Client::indexData(10, $column, $direction, $keyword, $assigned_filter, $status_filter);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newClient = Client::create($request->all());
        return $newClient->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $client =  Client::with('assignment','assignment.user','step', 'step.status')->find($id);
        $client =  Client::find($id);


        return $client;
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
        $client = Client::with('assignment','assignment.user','step', 'step.status')->findOrFail($id);
        $user = Auth::user();
        $user_id = $user->id;

        $all_fields = $request->all();

        if (!$client->step || ($client->step->status_id != $request->status_id)) {

                $step = Step::create([
                    'client_id' => intval($id),
                    'status_id' => $request->status_id,
                    'created_by' => $user_id,
                    'modified_by' => $user_id
                ]);

                $all_fields['step_id'] = $step->id;

        }

        if ($client->assignment_id != $request->assignment_id) {

            Assignment::create([
                'client_id' => intval($id),
                'user_id' => $request->assignment_id,
                'created_by' => $user_id,
                'modified_by' => $user_id
            ]);

        }




        $client->update($all_fields);

        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::find($id)->delete();

        return 204;
    }
}
