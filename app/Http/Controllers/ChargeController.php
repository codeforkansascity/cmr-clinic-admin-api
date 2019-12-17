<?php

namespace App\Http\Controllers;


use App\Http\Middleware\TrimStrings;
use App\Charge;
use Illuminate\Http\Request;

use App\Http\Requests\ChargeFormRequest;
use App\Http\Requests\ChargeIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\ChargeExport;
use Maatwebsite\Excel\Facades\Excel;

//use PDF; // TCPDF, not currently in use

class ChargeController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
     * <ui-select-pick-one
     * url="/api-charge/options"
     * v-model="chargeSelected"
     * :selected_id=chargeSelected">
     * </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
     * $charge_options = \App\Charge::getOptions();
     *
     *   In View
     *
     * @component('../components/select-pick-one', [
     * 'fld' => 'charge_id',
     * 'selected_id' => $RECORD->charge_id,
     * 'first_option' => 'Select a Charges',
     * 'options' => $charge_options
     * ])
     * @endcomponent
     *
     * Permissions
     *
     *
     * Permission::create(['name' => 'charge index']);
     * Permission::create(['name' => 'charge add']);
     * Permission::create(['name' => 'charge update']);
     * Permission::create(['name' => 'charge view']);
     * Permission::create(['name' => 'charge destroy']);
     * Permission::create(['name' => 'charge export-pdf']);
     * Permission::create(['name' => 'charge export-excel']);
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ChargeIndexRequest $request)
    {

        if (!Auth::user()->can('charge index')) {
            \Session::flash('flash_error_message', 'You do not have access to Chargess.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('charge_page', '');
        $search = session('charge_keyword', '');
        $column = session('charge_column', 'Name');
        $direction = session('charge_direction', '-1');

        $can_add = Auth::user()->can('charge add');
        $can_show = Auth::user()->can('charge view');
        $can_edit = Auth::user()->can('charge edit');
        $can_delete = Auth::user()->can('charge delete');
        $can_excel = Auth::user()->can('charge excel');
        $can_pdf = Auth::user()->can('charge pdf');

        return view('charge.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->can('charge add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Charges.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('charge.index');
            } else {
                return Redirect::route('home');
            }
        }

        return view('charge.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChargeFormRequest $request)
    {

        $charge = Charge::create($request->all());

//          We need to see the real error
//        try {
        /// this was not returning the id
//            $saved = $charge->add($request->validated());
//        } catch (\Exception $e) {
//            return response()->json([
//                'message' => 'Unable to process request'
//            ], 400);
//        }

        \Session::flash('flash_success_message', 'Charge ' . $charge->name . ' was added');

        $charge = $this->sanitizeAndFind($charge->id);      // Get all of the things we need to display
                                                            // associated with a charge

        return response()->json([
            'message' => 'Added record',
            'charge' => $charge
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

        if (!Auth::user()->can('charge view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Charges.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('charge.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($charge = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('charge edit');
            $can_delete = Auth::user()->can('charge delete');
            return view('charge.show', compact('charge', 'can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Charges to display.');
            return Redirect::route('charge.index');
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
        if (!Auth::user()->can('charge edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Charges.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('charge.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($charge = $this->sanitizeAndFind($id)) {
            return view('charge.edit', compact('charge'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Charges to edit.');
            return Redirect::route('charge.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Charge $charge * @return \Illuminate\Http\Response
     */
    public function update(ChargeFormRequest $request, $id)
    {

//        if (!Auth::user()->can('charge update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Charges.');
//            if (!Auth::user()->can('charge index')) {
//                return Redirect::route('charge.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$charge = $this->sanitizeAndFind($id)) {
            //     \Session::flash('flash_error_message', 'Unable to find Charges to edit');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        /// save history
        /// This was moved to ChargeObserver
        //$charge->saveHistory($request);


        $request_fields = $request->all();

        $statute = null;
        if ($charge->statute_id != $request_fields['statute_id']) {
            $statute = \App\Statute::with('statutes_eligibility', 'superseded')->find(intval($request_fields['statute_id']));
        }

        $charge->fill($request_fields);

        if ($charge->isDirty()) {

            try {
                $charge->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Charges ' . $charge->name . ' was changed');

            if ($statute) {
                return response()->json([
                    'message' => 'Changed record',
                    'statute' => $statute
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Changed record'
                ], 200);
            }

        } else {
            \Session::flash('flash_info_message', 'No changes were made');
            return response()->json([
                'message' => 'No Changes'
            ], 200);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Charge $charge * @return \Illuminate\Http\Response
     */
    public function destroy(Charge $charge)
    {

        if (!Auth::user()->can('charge delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Charges.');
            if (Auth::user()->can('charge index')) {
                 return Redirect::route('charge.index');
            } else {
                return Redirect::route('home');
            }
        }


        if ($charge && $charge->canDelete()) {

            try {
                $charge->delete();
            } catch (\Exception $e) {
                return $e;
            }

            \Session::flash('flash_success_message', 'Invitation for ' . $charge->name . ' was removed.');
            // send success response
            return response()->json(['success' => 'Record Deleted'], 200);

        } else {
            \Session::flash('flash_error_message', 'Unable to find Invite to delete.');

        }

//        if (Auth::user()->can('charge index')) {
//             return Redirect::route('charge.index');
//        } else {
//            return Redirect::route('home');
//        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Charge or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\Charge::with('statute', 'statute.statutes_eligibility', 'statute.superseded')->find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('charge excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Charges.');
            if (Auth::user()->can('charge index')) {
                return Redirect::route('charge.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('charge_keyword', '');
        $column = session('charge_column', 'name');
        $direction = session('charge_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Charge::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new ChargeExport($dataQuery),
            'charge.xlsx');

    }


    public function print()
    {
        if (!Auth::user()->can('charge export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Charges');
            if (Auth::user()->can('charge index')) {
                return Redirect::route('charge.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('charge_keyword', '');
        $column = session('charge_column', 'name');
        $direction = session('charge_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'notes',
        ];
        $dataQuery = Charge::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('charge.print', compact('data'));

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('charge-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
