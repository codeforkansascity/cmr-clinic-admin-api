<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\ImportMshpChargeCode;
use Illuminate\Http\Request;

use App\Http\Requests\ImportMshpChargeCodeFormRequest;
use App\Http\Requests\ImportMshpChargeCodeIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\ImportMshpChargeCodeExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class ImportMshpChargeCodeController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-import-mshp-charge-code/options"
            v-model="import_mshp_charge_codeSelected"
            :selected_id=import_mshp_charge_codeSelected"
            name="import_mshp_charge_code">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $import_mshp_charge_code_options = \App\ImportMshpChargeCode::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'import_mshp_charge_code_id',
                'selected_id' => $RECORD->import_mshp_charge_code_id,
                'first_option' => 'Select a ImportMshpChargeCodes',
                'options' => $import_mshp_charge_code_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::findOrCreate('import_mshp_charge_code index');
             Permission::findOrCreate('import_mshp_charge_code view');
             Permission::findOrCreate('import_mshp_charge_code export-pdf');
             Permission::findOrCreate('import_mshp_charge_code export-excel');
             Permission::findOrCreate('import_mshp_charge_code add');
             Permission::findOrCreate('import_mshp_charge_code update');
             Permission::findOrCreate('import_mshp_charge_code destroy');

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ImportMshpChargeCodeIndexRequest $request)
    {

        if (!Auth::user()->can('import_mshp_charge_code index')) {
            \Session::flash('flash_error_message', 'You do not have access to Charge Codess.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('import_mshp_charge_code_page', '');
        $search = session('import_mshp_charge_code_keyword', '');
        $column = session('import_mshp_charge_code_column', 'short_description');
        $direction = session('import_mshp_charge_code_direction', '-1');

        $can_add = Auth::user()->can('import_mshp_charge_code add');
        $can_show = Auth::user()->can('import_mshp_charge_code view');
        $can_edit = Auth::user()->can('import_mshp_charge_code edit');
        $can_delete = Auth::user()->can('import_mshp_charge_code delete');
        $can_excel = Auth::user()->can('import_mshp_charge_code excel');
        $can_pdf = Auth::user()->can('import_mshp_charge_code pdf');

        return view('import-mshp-charge-code.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('import_mshp_charge_code add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Charge Codes.');
            if (Auth::user()->can('import_mshp_charge_code index')) {
                return Redirect::route('import-mshp-charge-code.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('import-mshp-charge-code.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImportMshpChargeCodeFormRequest $request)
    {

        $import_mshp_charge_code = new \App\ImportMshpChargeCode;

        try {
            $import_mshp_charge_code->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Charge Codes ' . $import_mshp_charge_code->name . ' was added.');

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

        if (!Auth::user()->can('import_mshp_charge_code view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Charge Codes.');
            if (Auth::user()->can('import_mshp_charge_code index')) {
                return Redirect::route('import-mshp-charge-code.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($import_mshp_charge_code = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('import_mshp_charge_code edit');
            $can_delete = (Auth::user()->can('import_mshp_charge_code delete') && $import_mshp_charge_code->canDelete());
            return view('import-mshp-charge-code.show', compact('import_mshp_charge_code','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Charge Codes to display.');
            return Redirect::route('import-mshp-charge-code.index');
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
        if (!Auth::user()->can('import_mshp_charge_code edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Charge Codes.');
            if (Auth::user()->can('import_mshp_charge_code index')) {
                return Redirect::route('import-mshp-charge-code.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($import_mshp_charge_code = $this->sanitizeAndFind($id)) {
            return view('import-mshp-charge-code.edit', compact('import_mshp_charge_code'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Charge Codes to edit.');
            return Redirect::route('import-mshp-charge-code.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ImportMshpChargeCode $import_mshp_charge_code     * @return \Illuminate\Http\Response
     */
    public function update(ImportMshpChargeCodeFormRequest $request, $id)
    {

//        if (!Auth::user()->can('import_mshp_charge_code update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Charge Codes.');
//            if (!Auth::user()->can('import_mshp_charge_code index')) {
//                return Redirect::route('import-mshp-charge-code.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$import_mshp_charge_code = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Charge Codes to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $import_mshp_charge_code->fill($request->all());

        if ($import_mshp_charge_code->isDirty()) {

            try {
                $import_mshp_charge_code->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Charge Codes ' . $import_mshp_charge_code->name . ' was changed.');
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
     * @param  \App\ImportMshpChargeCode $import_mshp_charge_code     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('import_mshp_charge_code delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Charge Codes.');
            if (Auth::user()->can('import_mshp_charge_code index')) {
                 return Redirect::route('import-mshp-charge-code.index');
            } else {
                return Redirect::route('home');
            }
        }

        $import_mshp_charge_code = $this->sanitizeAndFind($id);

        if ( $import_mshp_charge_code  && $import_mshp_charge_code->canDelete()) {

            try {
                $import_mshp_charge_code->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Charge Codes ' . $import_mshp_charge_code->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Charge Codes to delete.');

        }

        if (Auth::user()->can('import_mshp_charge_code index')) {
             return Redirect::route('import-mshp-charge-code.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return ImportMshpChargeCode or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\ImportMshpChargeCode::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('import_mshp_charge_code excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Charge Codes.');
            if (Auth::user()->can('import_mshp_charge_code index')) {
                return Redirect::route('import-mshp-charge-code.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('import_mshp_charge_code_keyword', '');
        $column = session('import_mshp_charge_code_column', 'name');
        $direction = session('import_mshp_charge_code_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = ImportMshpChargeCode::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new ImportMshpChargeCodeExport($dataQuery),
            'import-mshp-charge-code.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('import_mshp_charge_code export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Charge Codes.');
            if (Auth::user()->can('import_mshp_charge_code index')) {
                return Redirect::route('import-mshp-charge-code.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('import_mshp_charge_code_keyword', '');
        $column = session('import_mshp_charge_code_column', 'name');
        $direction = session('import_mshp_charge_code_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'mshp_version_id',
            'legacy_charge_code',
            'charge_type',
            'classification',
            'effective_date',
            'inactive_date',
            'short_description',
            'charge_code',
        ];
        $dataQuery = ImportMshpChargeCode::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('import-mshp-charge-code.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('import-mshp-charge-code-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
