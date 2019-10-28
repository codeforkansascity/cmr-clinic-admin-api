<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\Step;
use Illuminate\Http\Request;

use App\Http\Requests\StepFormRequest;
use App\Http\Requests\StepIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\StepExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class StepController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-step/options"
            v-model="stepSelected"
            :selected_id=stepSelected">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $step_options = \App\Step::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'step_id',
                'selected_id' => $RECORD->step_id,
                'first_option' => 'Select a Steps',
                'options' => $step_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::create(['name' => 'step index']);
             Permission::create(['name' => 'step add']);
             Permission::create(['name' => 'step update']);
             Permission::create(['name' => 'step view']);
             Permission::create(['name' => 'step destroy']);
             Permission::create(['name' => 'step export-pdf']);
             Permission::create(['name' => 'step export-excel']);

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StepIndexRequest $request)
    {

        if (!Auth::user()->can('step index')) {
            \Session::flash('flash_error_message', 'You do not have access to Steps.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('step_page', '');
        $search = session('step_keyword', '');
        $column = session('step_column', 'Name');
        $direction = session('step_direction', '-1');

        $can_add = Auth::user()->can('step add');
        $can_show = Auth::user()->can('step view');
        $can_edit = Auth::user()->can('step edit');
        $can_delete = Auth::user()->can('step delete');
        $can_excel = Auth::user()->can('step excel');
        $can_pdf = Auth::user()->can('step pdf');

        return view('step.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('step add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Step.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('step.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('step.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StepFormRequest $request)
    {

        $step = new \App\Step;

        try {
            $step->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Vc Vendor ' . $step->name . ' was added');

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

        if (!Auth::user()->can('step view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Step.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('step.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($step = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('step edit');
            $can_delete = Auth::user()->can('step delete');
            return view('step.show', compact('step','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Step to display.');
            return Redirect::route('step.index');
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
        if (!Auth::user()->can('step edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Step.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('step.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($step = $this->sanitizeAndFind($id)) {
            return view('step.edit', compact('step'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Step to edit.');
            return Redirect::route('step.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Step $step     * @return \Illuminate\Http\Response
     */
    public function update(StepFormRequest $request, $id)
    {

//        if (!Auth::user()->can('step update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Step.');
//            if (!Auth::user()->can('step index')) {
//                return Redirect::route('step.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$step = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Step to edit');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $step->fill($request->all());

        if ($step->isDirty()) {

            try {
                $step->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Step ' . $step->name . ' was changed');
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
     * @param  \App\Step $step     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('step delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Step.');
            if (Auth::user()->can('step index')) {
                 return Redirect::route('step.index');
            } else {
                return Redirect::route('home');
            }
        }

        $step = $this->sanitizeAndFind($id);

        if ( $step  && $step->canDelete()) {

            try {
                $step->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Invitation for ' . $step->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Invite to delete.');

        }

        if (Auth::user()->can('step index')) {
             return Redirect::route('step.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Step or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\Step::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('step excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Step.');
            if (Auth::user()->can('step index')) {
                return Redirect::route('step.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('step_keyword', '');
        $column = session('step_column', 'name');
        $direction = session('step_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Step::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new StepExport($dataQuery),
            'step.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('step export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Step');
            if (Auth::user()->can('step index')) {
                return Redirect::route('step.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('step_keyword', '');
        $column = session('step_column', 'name');
        $direction = session('step_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
            'applicant_id',
            'status_id',
        ];
        $dataQuery = Step::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('step.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('step-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
