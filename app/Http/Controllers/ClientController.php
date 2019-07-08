<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\Client;
use Illuminate\Http\Request;

use App\Http\Requests\ClientFormRequest;
use App\Http\Requests\ClientIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\ClientExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

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
    public function index(ClientIndexRequest $request)
    {

        if (!Auth::user()->can('client index')) {
            \Session::flash('flash_error_message', 'You do not have access to Applicantss.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('client_page', '');
        $search = session('client_keyword', '');
        $column = session('client_column', 'Name');
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

        if (!Auth::user()->can('client add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Applicants.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('client.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('client.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientFormRequest $request)
    {

        $client = new \App\Client;

        try {
            $client->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Vc Vendor ' . $client->name . ' was added');

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
            \Session::flash('flash_error_message', 'You do not have access to view a Applicants.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('client.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($client = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('client edit');
            $can_delete = Auth::user()->can('client delete');
            return view('client.show', compact('client','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Applicants to display.');
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
            \Session::flash('flash_error_message', 'You do not have access to edit a Applicants.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('client.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($client = $this->sanitizeAndFind($id)) {
            return view('client.edit', compact('client'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Applicants to edit.');
            return Redirect::route('client.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Client $client     * @return \Illuminate\Http\Response
     */
    public function update(ClientFormRequest $request, $id)
    {

//        if (!Auth::user()->can('client update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Applicants.');
//            if (!Auth::user()->can('client index')) {
//                return Redirect::route('client.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$client = $this->sanitizeAndFind($id)) {
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

            \Session::flash('flash_success_message', 'Applicants ' . $client->name . ' was changed');
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
            \Session::flash('flash_error_message', 'You do not have access to remove a Applicants.');
            if (Auth::user()->can('client index')) {
                 return Redirect::route('client.index');
            } else {
                return Redirect::route('home');
            }
        }

        $client = $this->sanitizeAndFind($id);

        if ( $client  && $client->canDelete()) {

            try {
                $client->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Invitation for ' . $client->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Invite to delete.');

        }

        if (Auth::user()->can('client index')) {
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
    private function sanitizeAndFind($id)
    {
        return \App\Client::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('client excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Applicants.');
            if (Auth::user()->can('client index')) {
                return Redirect::route('client.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('client_keyword', '');
        $column = session('client_column', 'name');
        $direction = session('client_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Client::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new ClientExport($dataQuery),
            'client.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('client export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Applicants');
            if (Auth::user()->can('client index')) {
                return Redirect::route('client.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('client_keyword', '');
        $column = session('client_column', 'name');
        $direction = session('client_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
            'phone',
            'filing_court',
            'notes',
        ];
        $dataQuery = Client::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('client.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('client-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
