<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\RoleDescription;
use Illuminate\Http\Request;

use App\Http\Requests\RoleDescriptionFormRequest;
use App\Http\Requests\RoleDescriptionIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\RoleDescriptionExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class RoleDescriptionController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-role-description/options"
            v-model="role_descriptionSelected"
            :selected_id=role_descriptionSelected"
            name="role_description">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $role_description_options = \App\RoleDescription::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'role_description_id',
                'selected_id' => $RECORD->role_description_id,
                'first_option' => 'Select a RoleDescriptions',
                'options' => $role_description_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::create(['name' => 'role_description index']);
             Permission::create(['name' => 'role_description add']);
             Permission::create(['name' => 'role_description edit']);
             Permission::create(['name' => 'role_description view']);
             Permission::create(['name' => 'role_description delete']);
             Permission::create(['name' => 'role_description export-pdf']);
             Permission::create(['name' => 'role_description export-excel']);

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleDescriptionIndexRequest $request)
    {

        if (!Auth::user()->can('role_description index')) {
            \Session::flash('flash_error_message', 'You do not have access to Role Descriptionss.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('role_description_page', '');
        $search = session('role_description_keyword', '');
        $column = session('role_description_column', 'Name');
        $direction = session('role_description_direction', '-1');

        $can_add = Auth::user()->can('role_description add');
        $can_show = Auth::user()->can('role_description view');
        $can_edit = Auth::user()->can('role_description edit');
        $can_delete = Auth::user()->can('role_description delete');
        $can_excel = Auth::user()->can('role_description export-excel');
        $can_pdf = Auth::user()->can('role_description pdf');

        return view('role-description.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('role_description add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Role Descriptions.');
            if (Auth::user()->can('role_description index')) {
                return Redirect::route('role-description.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('role-description.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleDescriptionFormRequest $request)
    {

        $role_description = new \App\RoleDescription;

        try {
            $role_description->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Role Descriptions ' . $role_description->name . ' was added.');

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

        if (!Auth::user()->can('role_description view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Role Descriptions.');
            if (Auth::user()->can('role_description index')) {
                return Redirect::route('role-description.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($role_description = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('role_description edit');
            $can_delete = Auth::user()->can('role_description delete');
            return view('role-description.show', compact('role_description','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Role Descriptions to display.');
            return Redirect::route('role-description.index');
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
        if (!Auth::user()->can('role_description edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Role Descriptions.');
            if (Auth::user()->can('role_description index')) {
                return Redirect::route('role-description.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($role_description = $this->sanitizeAndFind($id)) {
            return view('role-description.edit', compact('role_description'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Role Descriptions to edit.');
            return Redirect::route('role-description.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\RoleDescription $role_description     * @return \Illuminate\Http\Response
     */
    public function update(RoleDescriptionFormRequest $request, $id)
    {

//        if (!Auth::user()->can('role_description edit')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Role Descriptions.');
//            if (!Auth::user()->can('role_description index')) {
//                return Redirect::route('role-description.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$role_description = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Role Descriptions to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $role_description->fill($request->all());

        if ($role_description->isDirty()) {

            try {
                $role_description->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Role Descriptions ' . $role_description->name . ' was changed.');
        } else {
            \Session::flash('flash_info_message', 'No changes were made.');
        }

        return response()->json([
            'message' => 'Changed record'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoleDescription $role_description     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('role_description delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Role Descriptions.');
            if (Auth::user()->can('role_description index')) {
                 return Redirect::route('role-description.index');
            } else {
                return Redirect::route('home');
            }
        }

        $role_description = $this->sanitizeAndFind($id);

        if ( $role_description  && $role_description->canDelete()) {

            try {
                $role_description->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Role Descriptions ' . $role_description->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Role Descriptions to delete.');

        }

        if (Auth::user()->can('role_description index')) {
             return Redirect::route('role-description.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return RoleDescription or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\RoleDescription::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('role_description export-excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Role Descriptions.');
            if (Auth::user()->can('role_description index')) {
                return Redirect::route('role-description.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('role_description_keyword', '');
        $column = session('role_description_column', 'name');
        $direction = session('role_description_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = RoleDescription::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new RoleDescriptionExport($dataQuery),
            'role-description.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('role_description export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Role Descriptions.');
            if (Auth::user()->can('role_description index')) {
                return Redirect::route('role-description.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('role_description_keyword', '');
        $column = session('role_description_column', 'name');
        $direction = session('role_description_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
        ];
        $dataQuery = RoleDescription::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('role-description.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('role-description-' . $currentDate->format('Ymd_Hi') . '.pdf');

        /*
        ///////////////////////////////////////////////////////////////////////
        /// Begin TCPDF/tcpdf-laravel test - keeping for reference
        // NOTE: you'll need to uncomment the use at the top for "PDF"
        PDF::SetTitle('Vendors');
        PDF::SetAutoPageBreak(TRUE, 15);
        PDF::SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT, 15);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);
        PDF::setHeaderCallback(function($pdf){
            $currentDate = new \DateTime();
            $currentDate->setTimezone(new \DateTimeZone('America/Chicago'));
            $pdf->Cell(0,10,'Date ' . $currentDate->format('Y-m-d g:ia'),0,false,'C',0,'',0,false,'T','M');
        });
        PDF::setFooterCallback(function($pdf){
            //$pdf->SetY(-15);
            //var_dump(get_class_methods('Elibyy\TCPDF\TCPDFHelper')); exit;
            $pdf->Cell(0,10,'Page ' . $pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(),0,false,'C',0,'',0,false,'T','M');
        });
        PDF::AddPage('L'); // Landscape
        //var_dump($dataQuery->get()); exit;
        //var_dump(get_class_methods('App\Exports\VcVendorExport')); exit; // query headings map download store queue toResponse
        PDF::writeHTML($html);
        PDF::Output('vc-vendor.pdf');
        /// End TCPDF/tcpdf-laravel test
        ///////////////////////////////////////////////////////////////////////
        */
    }

}
