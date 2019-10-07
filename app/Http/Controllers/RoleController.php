<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleEditRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\RoleExport;
use Maatwebsite\Excel\Facades\Excel;

class RoleController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            label="My Label"
            url="/api-role/options"
            class="form-group"
            v-model="roleSelected"
            v-on:input="getData">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $role_options = \App\Role::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'role_id',
                'selected_id' => $RECORD->role_id,
                'first_option' => 'Select a Roles',
                'options' => $role_options
            ])
            @endcomponent
    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // Remember the search parameters, we saved them in the Query
        $page = session('role_page', '');
        $search = session('role_keyword', '');
        $column = session('role_column', 'Name');
        $direction = session('role_direction', '-1');

        $can_add = true; // Auth::user()->isAllowed('role-add');
        $can_edit = true; // Auth::user()->isAllowed('role-edit');
        $can_delete = true; // Auth::user()->isAllowed('role-delete');
        $can_show = true; // Auth::user()->isAllowed('role-show');
        $can_excel = true; // Auth::user()->isAllowed('role-excel');

        return view('role.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create(Request $request)
	{
	    return view('role.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {

        $role = new \App\Role;

        if (!$role->add($request->all())) {
            \Session::flash('flash_error_message', 'Member could not be added.  Try again.');
            return redirect('role/create')
                ->withErrors($request->validator)
                ->withInput();
        }

        \Session::flash('flash_success_message', 'Role ' . $role->name . ' was added');

        return Redirect::route('role.index');

    }

    /**
     * Display the specified resource.
     *d
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($role = $this->find($id)) {
            return view('role.show', compact('role'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find role to display');
            return Redirect::route('role.index');
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

        if ($role = $this->find($id)) {
            return view('role.edit', compact('role'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find role to edit');
            return Redirect::route('role.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Role $role     * @return \Illuminate\Http\Response
     */
    public function update(RoleEditRequest $request, $id)
    {
        if (!$role = $this->find($id)) {
            \Session::flash('flash_error_message', 'Unable to find role to edit');
            return Redirect::route('role.index');
        }

        $role->fill($request->all());

        if ($role->isDirty()) {

            $role->save();

            \Session::flash('flash_success_message', 'Role ' . $role->name . ' was changed');
        } else {
            \Session::flash('flash_info_message', 'No changes were made');
        }

        return Redirect::route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role $role     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Role or null
     */
    private function find($id)
    {
        return \App\Role::find(intval($id));
    }


    public function download()
    {

        // Remember the search parameters, we saved them in the Query
        $search = session('role_keyword', '');
        $column = session('role_column', 'name');
        $direction = session('role_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Role::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new RoleExport($dataQuery),
            'role_.xlsx'
        );

        //} else {
        //    \Session::flash('flash_error_message', 'There are no organizations to download.');
        //    return Redirect::route('organization.index');
        //}

    }
	
}