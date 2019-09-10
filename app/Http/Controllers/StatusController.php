<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\Status;
use Illuminate\Http\Request;

use App\Http\Requests\StatusFormRequest;
use App\Http\Requests\StatusIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\StatusExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class StatusController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-status/options"
            v-model="statusSelected"
            :selected_id=statusSelected">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $status_options = \App\Status::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'status_id',
                'selected_id' => $RECORD->status_id,
                'first_option' => 'Select a Statuses',
                'options' => $status_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::create(['name' => 'status index']);
             Permission::create(['name' => 'status add']);
             Permission::create(['name' => 'status update']);
             Permission::create(['name' => 'status view']);
             Permission::create(['name' => 'status destroy']);
             Permission::create(['name' => 'status export-pdf']);
             Permission::create(['name' => 'status export-excel']);

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StatusIndexRequest $request)
    {

        if (!Auth::user()->can('status index')) {
            \Session::flash('flash_error_message', 'You do not have access to Statuss.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('status_page', '');
        $search = session('status_keyword', '');
        $column = session('status_column', 'Name');
        $direction = session('status_direction', '-1');

        $can_add = Auth::user()->can('status add');
        $can_show = Auth::user()->can('status view');
        $can_edit = Auth::user()->can('status edit');
        $can_delete = Auth::user()->can('status delete');
        $can_excel = Auth::user()->can('status excel');
        $can_pdf = Auth::user()->can('status pdf');

        return view('status.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('status add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Status.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('status.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('status.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusFormRequest $request)
    {

        $status = new \App\Status;

        try {
            $status->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Vc Vendor ' . $status->name . ' was added');

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

        if (!Auth::user()->can('status view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Status.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('status.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($status = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('status edit');
            $can_delete = Auth::user()->can('status delete');
            return view('status.show', compact('status','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Status to display.');
            return Redirect::route('status.index');
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
        if (!Auth::user()->can('status edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Status.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('status.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($status = $this->sanitizeAndFind($id)) {
            return view('status.edit', compact('status'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Status to edit.');
            return Redirect::route('status.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Status $status     * @return \Illuminate\Http\Response
     */
    public function update(StatusFormRequest $request, $id)
    {

//        if (!Auth::user()->can('status update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Status.');
//            if (!Auth::user()->can('status index')) {
//                return Redirect::route('status.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$status = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Status to edit');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $status->fill($request->all());

        if ($status->isDirty()) {

            try {
                $status->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Status ' . $status->name . ' was changed');
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
     * @param  \App\Status $status     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('status delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Status.');
            if (Auth::user()->can('status index')) {
                 return Redirect::route('status.index');
            } else {
                return Redirect::route('home');
            }
        }

        $status = $this->sanitizeAndFind($id);

        if ( $status  && $status->canDelete()) {

            try {
                $status->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Invitation for ' . $status->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Invite to delete.');

        }

        if (Auth::user()->can('status index')) {
             return Redirect::route('status.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Status or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\Status::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('status excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Status.');
            if (Auth::user()->can('status index')) {
                return Redirect::route('status.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('status_keyword', '');
        $column = session('status_column', 'name');
        $direction = session('status_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Status::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new StatusExport($dataQuery),
            'status.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('status export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Status');
            if (Auth::user()->can('status index')) {
                return Redirect::route('status.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('status_keyword', '');
        $column = session('status_column', 'name');
        $direction = session('status_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
            'alias',
            'sequence',
        ];
        $dataQuery = Status::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('status.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('status-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
