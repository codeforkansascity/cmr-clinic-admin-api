<?php

namespace App\Http\Controllers;


use App\Http\Middleware\TrimStrings;
use App\JurisdictionType;
use Illuminate\Http\Request;

use App\Http\Requests\JurisdictionTypeFormRequest;
use App\Http\Requests\JurisdictionTypeIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\JurisdictionTypeExport;
use Maatwebsite\Excel\Facades\Excel;

//use PDF; // TCPDF, not currently in use

class JurisdictionTypeController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
     * <ui-select-pick-one
     * url="/api-jurisdiction-type/options"
     * v-model="jurisdiction_typeSelected"
     * :selected_id=jurisdiction_typeSelected"
     * name="jurisdiction_type">
     * </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
     * $jurisdiction_type_options = \App\JurisdictionType::getOptions();
     *
     *   In View
     *
     * @component('../components/select-pick-one', [
     * 'fld' => 'jurisdiction_type_id',
     * 'selected_id' => $RECORD->jurisdiction_type_id,
     * 'first_option' => 'Select a JurisdictionTypes',
     * 'options' => $jurisdiction_type_options
     * ])
     * @endcomponent
     *
     * Permissions
     *
     *
     * Permission::findOrCreate('jurisdiction_type index');
     * Permission::findOrCreate('jurisdiction_type view');
     * Permission::findOrCreate('jurisdiction_type export-pdf');
     * Permission::findOrCreate('jurisdiction_type export-excel');
     * Permission::findOrCreate('jurisdiction_type add');
     * Permission::findOrCreate('jurisdiction_type update');
     * Permission::findOrCreate('jurisdiction_type destroy');
     */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JurisdictionTypeIndexRequest $request)
    {

        if (!Auth::user()->can('jurisdiction_type index')) {
            \Session::flash('flash_error_message', 'You do not have access to Jurisdiction Types.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('jurisdiction_type_page', '');
        $search = session('jurisdiction_type_keyword', '');
        $column = session('jurisdiction_type_column', 'Name');
        $direction = session('jurisdiction_type_direction', '-1');

        $can_add = Auth::user()->can('jurisdiction_type add');
        $can_show = Auth::user()->can('jurisdiction_type view');
        $can_edit = Auth::user()->can('jurisdiction_type edit');
        $can_delete = Auth::user()->can('jurisdiction_type delete');
        $can_excel = Auth::user()->can('jurisdiction_type excel');
        $can_pdf = Auth::user()->can('jurisdiction_type pdf');

        return view('jurisdiction-type.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->can('jurisdiction_type add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Jurisdiction Type.');
            if (Auth::user()->can('jurisdiction_type index')) {
                return Redirect::route('jurisdiction-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        return view('jurisdiction-type.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(JurisdictionTypeFormRequest $request)
    {

        $jurisdiction_type = new \App\JurisdictionType;

        try {
            $jurisdiction_type->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Jurisdiction Type ' . $jurisdiction_type->name . ' was added.');

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

        if (!Auth::user()->can('jurisdiction_type view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Jurisdiction Type.');
            if (Auth::user()->can('jurisdiction_type index')) {
                return Redirect::route('jurisdiction-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($jurisdiction_type = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('jurisdiction_type edit');
            $can_delete = (Auth::user()->can('jurisdiction_type delete') && $jurisdiction_type->canDelete());
            return view('jurisdiction-type.show', compact('jurisdiction_type', 'can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Jurisdiction Type to display.');
            return Redirect::route('jurisdiction-type.index');
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
        if (!Auth::user()->can('jurisdiction_type edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Jurisdiction Type.');
            if (Auth::user()->can('jurisdiction_type index')) {
                return Redirect::route('jurisdiction-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($jurisdiction_type = $this->sanitizeAndFind($id)) {
            return view('jurisdiction-type.edit', compact('jurisdiction_type'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Jurisdiction Type to edit.');
            return Redirect::route('jurisdiction-type.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\JurisdictionType $jurisdiction_type * @return \Illuminate\Http\Response
     */
    public function update(JurisdictionTypeFormRequest $request, $id)
    {

//        if (!Auth::user()->can('jurisdiction_type update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Jurisdiction Type.');
//            if (!Auth::user()->can('jurisdiction_type index')) {
//                return Redirect::route('jurisdiction-type.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$jurisdiction_type = $this->sanitizeAndFind($id)) {
            //     \Session::flash('flash_error_message', 'Unable to find Jurisdiction Type to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $jurisdiction_type->fill($request->all());

        if ($jurisdiction_type->isDirty()) {

            try {
                $jurisdiction_type->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Jurisdiction Type ' . $jurisdiction_type->name . ' was changed.');
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
     * @param  \App\JurisdictionType $jurisdiction_type * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('jurisdiction_type delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Jurisdiction Type.');
            if (Auth::user()->can('jurisdiction_type index')) {
                return Redirect::route('jurisdiction-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        $jurisdiction_type = $this->sanitizeAndFind($id);

        if ($jurisdiction_type && $jurisdiction_type->canDelete()) {

            try {
                $jurisdiction_type->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Jurisdiction Type ' . $jurisdiction_type->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Jurisdiction Type to delete.');

        }

        if (Auth::user()->can('jurisdiction_type index')) {
            return Redirect::route('jurisdiction-type.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return JurisdictionType or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\JurisdictionType::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('jurisdiction_type excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Jurisdiction Types.');
            if (Auth::user()->can('jurisdiction_type index')) {
                return Redirect::route('jurisdiction-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('jurisdiction_type_keyword', '');
        $column = session('jurisdiction_type_column', 'name');
        $direction = session('jurisdiction_type_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = JurisdictionType::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new JurisdictionTypeExport($dataQuery),
            'jurisdiction-type.xlsx');

    }


    public function print()
    {
        if (!Auth::user()->can('jurisdiction_type export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Jurisdiction Types.');
            if (Auth::user()->can('jurisdiction_type index')) {
                return Redirect::route('jurisdiction-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('jurisdiction_type_keyword', '');
        $column = session('jurisdiction_type_column', 'name');
        $direction = session('jurisdiction_type_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
            'display_sequence',
        ];
        $dataQuery = JurisdictionType::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('jurisdiction-type.print', compact('data'));

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('jurisdiction-type-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
