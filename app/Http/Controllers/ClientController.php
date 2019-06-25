<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\Client;
use Illuminate\Http\Request;

use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\ClientExport;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            label="My Label"
            url="/api-client/options"
            class="form-group"
            v-model="clientSelected"
            v-on:input="getData">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $client_options = \App\Client::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'client_id',
                'selected_id' => $RECORD->client_id,
                'first_option' => 'Select a Clients',
                'options' => $client_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::create(['name' => 'client index']);
             Permission::create(['name' => 'client add']);
             Permission::create(['name' => 'client update']);
             Permission::create(['name' => 'client view']);
             Permission::create(['name' => 'client destroy']);
             Permission::create(['name' => 'client export-pdf']);
             Permission::create(['name' => 'client export-excel']);

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Auth::user()->can('client index')) {
            \Session::flash('flash_error_message', 'You do not have access to Applicants');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('client_page', '');
        $search = session('client_keyword', '');
        $column = session('client_column', 'full_name');
        $direction = session('client_direction', '-1');

        $can_add = Auth::user()->can('client add');
        $can_show = Auth::user()->can('client view');
        $can_edit = Auth::user()->can('client edit');
        $can_delete = Auth::user()->can('client delete');
        $can_excel = Auth::user()->can('client excel');
        $can_pdf = Auth::user()->can('client pdf');

        return view('client.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('client add')) {
            \Session::flash('flash_error_message', 'You do not have access to add a Applicants');
            return Redirect::route('home');
        }

	    return view('client.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {

        $client = new \App\Client;

        try {
            $client->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Vc Vendor ' . $client->full_name . ' was added');

        return response()->json([
            'message' => 'Added record'
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (!Auth::user()->can('client view')) {
            \Session::flash('flash_error_message', 'You do not have access to add a Applicants');
            return Redirect::route('home');
        }

        if ($client = $this->find($id)) {
            return view('client.show', compact('client'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Applicants to display');
            return Redirect::route('client.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->can('client edit')) {
            \Session::flash('flash_error_message', 'You do not have access to add a Applicants');
            return Redirect::route('home');
        }

        if ($client = $this->find($id)) {
            return view('client.edit', compact('client'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Applicants to edit');
            return Redirect::route('client.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Client $client     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        if (!$client = $this->find($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Applicants to edit');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $client->fill($request->all());

        if ($client->isDirty()) {

            try {
                $client->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Applicants ' . $client->full_name . ' was changed');
        } else {
            \Session::flash('flash_info_message', 'No changes were made');
        }

        return response()->json([
            'message' => 'Changed record'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client $client     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('client delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Applicants');
            if (!Auth::user()->can('client index')) {
                 return Redirect::route('client.index');
            } else {
                return Redirect::route('home');
            }
        }

        $client = $this->find($id);
        if ( $client) {
            $client->delete();
            \Session::flash('flash_success_message', 'Invitation for ' . $client->full_name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Invite to delete');

        }

        if (!Auth::user()->can('client index')) {
             return Redirect::route('client.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Client or null
     */
    private function find($id)
    {
        return \App\Client::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('client excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Applicants');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('client_keyword', '');
        $column = session('client_column', 'full_name');
        $direction = session('client_direction', '-1');

        $column = $column ? $column : 'full_name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Client::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new ClientExport($dataQuery),
            'client.xlsx'
        );

        //} else {
        //    \Session::flash('flash_error_message', 'There are no organizations to download.');
        //    return Redirect::route('organization.index');
        //}

    }

}
