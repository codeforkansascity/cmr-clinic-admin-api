<?php

namespace App\Http\Controllers;


use App\Http\Middleware\TrimStrings;
use App\Jurisdiction;
use Illuminate\Http\Request;

use App\Http\Requests\JurisdictionFormRequest;
use App\Http\Requests\JurisdictionIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\JurisdictionExport;
use Maatwebsite\Excel\Facades\Excel;

//use PDF; // TCPDF, not currently in use

class JurisdictionController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
     * <ui-select-pick-one
     * url="/api-jurisdiction/options"
     * v-model="jurisdictionSelected"
     * :selected_id=jurisdictionSelected"
     * name="jurisdiction">
     * </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
     * $jurisdiction_options = \App\Jurisdiction::getOptions();
     *
     *   In View
     *
     * @component('../components/select-pick-one', [
     * 'fld' => 'jurisdiction_id',
     * 'selected_id' => $RECORD->jurisdiction_id,
     * 'first_option' => 'Select a Jurisdictions',
     * 'options' => $jurisdiction_options
     * ])
     * @endcomponent
     *
     * Permissions
     *
     *
     * Permission::findOrCreate('jurisdiction index');
     * Permission::findOrCreate('jurisdiction view');
     * Permission::findOrCreate('jurisdiction export-pdf');
     * Permission::findOrCreate('jurisdiction export-excel');
     * Permission::findOrCreate('jurisdiction add');
     * Permission::findOrCreate('jurisdiction update');
     * Permission::findOrCreate('jurisdiction destroy');
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JurisdictionIndexRequest $request)
    {

        if (!Auth::user()->can('jurisdiction index')) {
            \Session::flash('flash_error_message', 'You do not have access to Jurisdictions.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('jurisdiction_page', '');
        $search = session('jurisdiction_keyword', '');
        $column = session('jurisdiction_column', 'Name');
        $direction = session('jurisdiction_direction', '-1');

        $can_add = Auth::user()->can('jurisdiction add');
        $can_show = Auth::user()->can('jurisdiction view');
        $can_edit = Auth::user()->can('jurisdiction edit');
        $can_delete = Auth::user()->can('jurisdiction delete');
        $can_excel = Auth::user()->can('jurisdiction excel');
        $can_pdf = Auth::user()->can('jurisdiction pdf');

        return view('jurisdiction.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->can('jurisdiction add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Jurisdiction.');
            if (Auth::user()->can('jurisdiction index')) {
                return Redirect::route('jurisdiction.index');
            } else {
                return Redirect::route('home');
            }
        }

        return view('jurisdiction.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(JurisdictionFormRequest $request)
    {

        $jurisdiction = new \App\Jurisdiction;

        try {
            $jurisdiction->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Jurisdiction ' . $jurisdiction->name . ' was added.');

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

        if (!Auth::user()->can('jurisdiction view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Jurisdiction.');
            if (Auth::user()->can('jurisdiction index')) {
                return Redirect::route('jurisdiction.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($jurisdiction = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('jurisdiction edit');
            $can_delete = (Auth::user()->can('jurisdiction delete') && $jurisdiction->canDelete());
            return view('jurisdiction.show', compact('jurisdiction', 'can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Jurisdiction to display.');
            return Redirect::route('jurisdiction.index');
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
        if (!Auth::user()->can('jurisdiction edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Jurisdiction.');
            if (Auth::user()->can('jurisdiction index')) {
                return Redirect::route('jurisdiction.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($jurisdiction = $this->sanitizeAndFind($id)) {
            return view('jurisdiction.edit', compact('jurisdiction'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Jurisdiction to edit.');
            return Redirect::route('jurisdiction.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Jurisdiction $jurisdiction * @return \Illuminate\Http\Response
     */
    public function update(JurisdictionFormRequest $request, $id)
    {

//        if (!Auth::user()->can('jurisdiction update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Jurisdiction.');
//            if (!Auth::user()->can('jurisdiction index')) {
//                return Redirect::route('jurisdiction.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$jurisdiction = $this->sanitizeAndFind($id)) {
            //     \Session::flash('flash_error_message', 'Unable to find Jurisdiction to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $jurisdiction->fill($request->all());

        if ($jurisdiction->isDirty()) {

            try {
                $jurisdiction->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Jurisdiction ' . $jurisdiction->name . ' was changed.');
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
     * @param  \App\Jurisdiction $jurisdiction * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('jurisdiction delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Jurisdiction.');
            if (Auth::user()->can('jurisdiction index')) {
                return Redirect::route('jurisdiction.index');
            } else {
                return Redirect::route('home');
            }
        }

        $jurisdiction = $this->sanitizeAndFind($id);

        if ($jurisdiction && $jurisdiction->canDelete()) {

            try {
                $jurisdiction->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Jurisdiction ' . $jurisdiction->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Jurisdiction to delete.');

        }

        if (Auth::user()->can('jurisdiction index')) {
            return Redirect::route('jurisdiction.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Jurisdiction or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\Jurisdiction::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('jurisdiction excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Jurisdictions.');
            if (Auth::user()->can('jurisdiction index')) {
                return Redirect::route('jurisdiction.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('jurisdiction_keyword', '');
        $column = session('jurisdiction_column', 'name');
        $direction = session('jurisdiction_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Jurisdiction::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new JurisdictionExport($dataQuery),
            'jurisdiction.xlsx');

    }


    public function print()
    {
        if (!Auth::user()->can('jurisdiction export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Jurisdictions.');
            if (Auth::user()->can('jurisdiction index')) {
                return Redirect::route('jurisdiction.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('jurisdiction_keyword', '');
        $column = session('jurisdiction_column', 'name');
        $direction = session('jurisdiction_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'jurisdiction_type_id',
            'name',
            'url',
        ];
        $dataQuery = Jurisdiction::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('jurisdiction.print', compact('data'));

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('jurisdiction-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
