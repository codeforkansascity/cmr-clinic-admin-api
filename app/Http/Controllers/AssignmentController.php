<?php

namespace App\Http\Controllers;


use App\Http\Middleware\TrimStrings;
use App\Assignment;
use Illuminate\Http\Request;

use App\Http\Requests\AssignmentFormRequest;
use App\Http\Requests\AssignmentIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\AssignmentExport;
use Maatwebsite\Excel\Facades\Excel;

//use PDF; // TCPDF, not currently in use

class AssignmentController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
     * <ui-select-pick-one
     * url="/api-assignment/options"
     * v-model="assignmentSelected"
     * :selected_id=assignmentSelected">
     * </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
     * $assignment_options = \App\Assignment::getOptions();
     *
     *   In View
     *
     * @component('../components/select-pick-one', [
     * 'fld' => 'assignment_id',
     * 'selected_id' => $RECORD->assignment_id,
     * 'first_option' => 'Select a Assignments',
     * 'options' => $assignment_options
     * ])
     * @endcomponent
     *
     * Permissions
     *
     *
     * Permission::create(['name' => 'assignment index']);
     * Permission::create(['name' => 'assignment add']);
     * Permission::create(['name' => 'assignment update']);
     * Permission::create(['name' => 'assignment view']);
     * Permission::create(['name' => 'assignment destroy']);
     * Permission::create(['name' => 'assignment export-pdf']);
     * Permission::create(['name' => 'assignment export-excel']);
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AssignmentIndexRequest $request)
    {

        if (!Auth::user()->can('assignment index')) {
            \Session::flash('flash_error_message', 'You do not have access to Assignments.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('assignment_page', '');
        $search = session('assignment_keyword', '');
        $column = session('assignment_column', 'Name');
        $direction = session('assignment_direction', '-1');

        $can_add = Auth::user()->can('assignment add');
        $can_show = Auth::user()->can('assignment view');
        $can_edit = Auth::user()->can('assignment edit');
        $can_delete = Auth::user()->can('assignment delete');
        $can_excel = Auth::user()->can('assignment excel');
        $can_pdf = Auth::user()->can('assignment pdf');

        return view('assignment.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->can('assignment add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Assignment.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('assignment.index');
            } else {
                return Redirect::route('home');
            }
        }

        return view('assignment.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentFormRequest $request)
    {

        $assignment = new \App\Assignment;

        try {
            $assignment->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Vc Vendor ' . $assignment->name . ' was added');

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

        if (!Auth::user()->can('assignment view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Assignment.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('assignment.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($assignment = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('assignment edit');
            $can_delete = Auth::user()->can('assignment delete');
            return view('assignment.show', compact('assignment', 'can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Assignment to display.');
            return Redirect::route('assignment.index');
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
        if (!Auth::user()->can('assignment edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Assignment.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('assignment.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($assignment = $this->sanitizeAndFind($id)) {
            return view('assignment.edit', compact('assignment'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Assignment to edit.');
            return Redirect::route('assignment.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Assignment $assignment * @return \Illuminate\Http\Response
     */
    public function update(AssignmentFormRequest $request, $id)
    {

//        if (!Auth::user()->can('assignment update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Assignment.');
//            if (!Auth::user()->can('assignment index')) {
//                return Redirect::route('assignment.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$assignment = $this->sanitizeAndFind($id)) {
            //     \Session::flash('flash_error_message', 'Unable to find Assignment to edit');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $assignment->fill($request->all());

        if ($assignment->isDirty()) {

            try {
                $assignment->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Assignment ' . $assignment->name . ' was changed');
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
     * @param  \App\Assignment $assignment * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('assignment delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Assignment.');
            if (Auth::user()->can('assignment index')) {
                return Redirect::route('assignment.index');
            } else {
                return Redirect::route('home');
            }
        }

        $assignment = $this->sanitizeAndFind($id);

        if ($assignment && $assignment->canDelete()) {

            try {
                $assignment->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Invitation for ' . $assignment->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Invite to delete.');

        }

        if (Auth::user()->can('assignment index')) {
            return Redirect::route('assignment.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Assignment or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\Assignment::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('assignment excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Assignment.');
            if (Auth::user()->can('assignment index')) {
                return Redirect::route('assignment.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('assignment_keyword', '');
        $column = session('assignment_column', 'name');
        $direction = session('assignment_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Assignment::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new AssignmentExport($dataQuery),
            'assignment.xlsx');

    }


    public function print()
    {
        if (!Auth::user()->can('assignment export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Assignment');
            if (Auth::user()->can('assignment index')) {
                return Redirect::route('assignment.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('assignment_keyword', '');
        $column = session('assignment_column', 'name');
        $direction = session('assignment_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
            'applicant_id',
            'user_id',
        ];
        $dataQuery = Assignment::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('assignment.print', compact('data'));

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('assignment-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
