<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\DataSource;
use Illuminate\Http\Request;

use App\Http\Requests\DataSourceFormRequest;
use App\Http\Requests\DataSourceIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\DataSourceExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class DataSourceController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-data-source/options"
            v-model="data_sourceSelected"
            :selected_id=data_sourceSelected"
            name="data_source">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $data_source_options = \App\DataSource::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'data_source_id',
                'selected_id' => $RECORD->data_source_id,
                'first_option' => 'Select a DataSources',
                'options' => $data_source_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::findOrCreate('data_source index');
             Permission::findOrCreate('data_source view');
             Permission::findOrCreate('data_source export-pdf');
             Permission::findOrCreate('data_source export-excel');
             Permission::findOrCreate('data_source add');
             Permission::findOrCreate('data_source edit');
             Permission::findOrCreate('data_source delete');

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DataSourceIndexRequest $request)
    {

        if (!Auth::user()->can('data_source index')) {
            \Session::flash('flash_error_message', 'You do not have access to Sourcess.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('data_source_page', '');
        $search = session('data_source_keyword', '');
        $column = session('data_source_column', 'Name');
        $direction = session('data_source_direction', '-1');

        $can_add = Auth::user()->can('data_source add');
        $can_show = Auth::user()->can('data_source view');
        $can_edit = Auth::user()->can('data_source edit');
        $can_delete = Auth::user()->can('data_source delete');
        $can_excel = Auth::user()->can('data_source excel');
        $can_pdf = Auth::user()->can('data_source pdf');

        return view('data-source.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('data_source add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Sources.');
            if (Auth::user()->can('data_source index')) {
                return Redirect::route('data-source.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('data-source.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataSourceFormRequest $request)
    {

        $data_source = new \App\DataSource;

        try {
            $data_source->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Sources ' . $data_source->name . ' was added.');

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

        if (!Auth::user()->can('data_source view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Sources.');
            if (Auth::user()->can('data_source index')) {
                return Redirect::route('data-source.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($data_source = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('data_source edit');
            $can_delete = (Auth::user()->can('data_source delete') && $data_source->canDelete());
            return view('data-source.show', compact('data_source','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Sources to display.');
            return Redirect::route('data-source.index');
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
        if (!Auth::user()->can('data_source edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Sources.');
            if (Auth::user()->can('data_source index')) {
                return Redirect::route('data-source.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($data_source = $this->sanitizeAndFind($id)) {
            return view('data-source.edit', compact('data_source'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Sources to edit.');
            return Redirect::route('data-source.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\DataSource $data_source     * @return \Illuminate\Http\Response
     */
    public function update(DataSourceFormRequest $request, $id)
    {

//        if (!Auth::user()->can('data_source update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Sources.');
//            if (!Auth::user()->can('data_source index')) {
//                return Redirect::route('data-source.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$data_source = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Sources to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $data_source->fill($request->all());

        if ($data_source->isDirty()) {

            try {
                $data_source->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Sources ' . $data_source->name . ' was changed.');
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
     * @param  \App\DataSource $data_source     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('data_source delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Sources.');
            if (Auth::user()->can('data_source index')) {
                 return Redirect::route('data-source.index');
            } else {
                return Redirect::route('home');
            }
        }

        $data_source = $this->sanitizeAndFind($id);

        if ( $data_source  && $data_source->canDelete()) {

            try {
                $data_source->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Sources ' . $data_source->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Sources to delete.');

        }

        if (Auth::user()->can('data_source index')) {
             return Redirect::route('data-source.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return DataSource or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\DataSource::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('data_source excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Sources.');
            if (Auth::user()->can('data_source index')) {
                return Redirect::route('data-source.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('data_source_keyword', '');
        $column = session('data_source_column', 'name');
        $direction = session('data_source_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = DataSource::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new DataSourceExport($dataQuery),
            'data-source.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('data_source export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Sources.');
            if (Auth::user()->can('data_source index')) {
                return Redirect::route('data-source.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('data_source_keyword', '');
        $column = session('data_source_column', 'name');
        $direction = session('data_source_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
            'description',
        ];
        $dataQuery = DataSource::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('data-source.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('data-source-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
