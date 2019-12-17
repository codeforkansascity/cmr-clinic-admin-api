<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\Conviction;
use Illuminate\Http\Request;

use App\Http\Requests\ConvictionFormRequest;
use App\Http\Requests\ConvictionIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\ConvictionExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class ConvictionController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-conviction/options"
            v-model="convictionSelected"
            :selected_id=convictionSelected">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $conviction_options = \App\Conviction::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'conviction_id',
                'selected_id' => $RECORD->conviction_id,
                'first_option' => 'Select a Convictions',
                'options' => $conviction_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::create(['name' => 'conviction index']);
             Permission::create(['name' => 'conviction add']);
             Permission::create(['name' => 'conviction update']);
             Permission::create(['name' => 'conviction view']);
             Permission::create(['name' => 'conviction destroy']);
             Permission::create(['name' => 'conviction export-pdf']);
             Permission::create(['name' => 'conviction export-excel']);

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ConvictionIndexRequest $request)
    {

        if (!Auth::user()->can('conviction index')) {
            \Session::flash('flash_error_message', 'You do not have access to Cases.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('conviction_page', '');
        $search = session('conviction_keyword', '');
        $column = session('conviction_column', 'Name');
        $direction = session('conviction_direction', '-1');

        $can_add = Auth::user()->can('conviction add');
        $can_show = Auth::user()->can('conviction view');
        $can_edit = Auth::user()->can('conviction edit');
        $can_delete = Auth::user()->can('conviction delete');
        $can_excel = Auth::user()->can('conviction excel');
        $can_pdf = Auth::user()->can('conviction pdf');

        return view('conviction.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('conviction add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Case.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('conviction.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('conviction.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConvictionFormRequest $request)
    {

        $conviction = Conviction::create($request->all());
        if($request->sources) {
            $conviction->sources()->sync(collect($request->sources)->pluck('id'));
        }
        /// We need to return the id to the front end
        ///
//        try {
//            $conviction->add($request->validated());
//        } catch (\Exception $e) {
//            return response()->json([
//                'message' => 'Unable to process request '.$e->getMessage()
//            ], 400);
//        }

        \Session::flash('flash_success_message', 'Vc Vendor ' . $conviction->name . ' was added');

        return response()->json([
            'message' => 'Added record',
            'record' => $conviction
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

        if (!Auth::user()->can('conviction view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Case.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('conviction.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($conviction = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('conviction edit');
            $can_delete = Auth::user()->can('conviction delete');
            return view('conviction.show', compact('conviction','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Case to display.');
            return Redirect::route('conviction.index');
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
        if (!Auth::user()->can('conviction edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Case.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('conviction.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($conviction = $this->sanitizeAndFind($id)) {
            return view('conviction.edit', compact('conviction'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Case to edit.');
            return Redirect::route('conviction.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Conviction $conviction     * @return \Illuminate\Http\Response
     */
    public function update(ConvictionFormRequest $request, $id)
    {

        info(__METHOD__ . ' start');

//        if (!Auth::user()->can('conviction update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Case.');
//            if (!Auth::user()->can('conviction index')) {
//                return Redirect::route('conviction.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$conviction = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Case to edit');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $conviction->fill($request->all());
        if($request->sources) {
            $conviction->sources()->sync(collect($request->sources)->pluck('id'));
        }

        if ($conviction->isDirty()) {
info(__METHOD__ . ' saving');
            try {
                $conviction->save();

            } catch (\Exception $e) {
                info(print_r($e->getMessage(),true));
                return response()->json([
                    'message' => 'Unable to process request',

                ], 400);
            }

            \Session::flash('flash_success_message', 'Case ' . $conviction->name . ' was changed');
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
     * @param  \App\Conviction $conviction     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // TODO change this to return error response
        if (!Auth::user()->can('conviction delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Case.');
            if (Auth::user()->can('applicant index')) {
                 return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        $conviction = $this->sanitizeAndFind($id);

        if ( $conviction  && $conviction->canDelete()) {

            try {
                $conviction->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Case ' . $conviction->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Case to delete.');

        }

        return response()->json('Success', 200);
        // TODO we cannot send a redirect from an ajax request
        // we should either use a form to submit the delete request or have the front end redirect if successful
        if (Auth::user()->can('conviction index')) {
             return Redirect::route('conviction.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Conviction or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\Conviction::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('conviction excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Case.');
            if (Auth::user()->can('conviction index')) {
                return Redirect::route('conviction.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('conviction_keyword', '');
        $column = session('conviction_column', 'name');
        $direction = session('conviction_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Conviction::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new ConvictionExport($dataQuery),
            'conviction.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('conviction export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Case');
            if (Auth::user()->can('conviction index')) {
                return Redirect::route('conviction.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('conviction_keyword', '');
        $column = session('conviction_column', 'name');
        $direction = session('conviction_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
            'notes',
        ];
        $dataQuery = Conviction::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('conviction.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('conviction-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
