<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\Exception;
use App\StatuteException;
use Illuminate\Http\Request;

use App\Http\Requests\ExceptionFormRequest;
use App\Http\Requests\ExceptionIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\ExceptionExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class ExceptionController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-exception/options"
            v-model="exceptionSelected"
            :selected_id=exceptionSelected"
            name="exception">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $exception_options = \App\Exception::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'exception_id',
                'selected_id' => $RECORD->exception_id,
                'first_option' => 'Select a Exceptions',
                'options' => $exception_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::findOrCreate('exception index');
             Permission::findOrCreate('exception view');
             Permission::findOrCreate('exception export-pdf');
             Permission::findOrCreate('exception export-excel');
             Permission::findOrCreate('exception add');
             Permission::findOrCreate('exception update');
             Permission::findOrCreate('exception destroy');

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExceptionIndexRequest $request)
    {

        if (!Auth::user()->can('exception index')) {
            \Session::flash('flash_error_message', 'You do not have access to Exceptionss.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('exception_page', '');
        $search = session('exception_keyword', '');
        $column = session('exception_column', 'sequence');
        $direction = session('exception_direction', '-1');

        $can_add = Auth::user()->can('exception add');
        $can_show = Auth::user()->can('exception view');
        $can_edit = Auth::user()->can('exception edit');
        $can_delete = Auth::user()->can('exception delete');
        $can_excel = Auth::user()->can('exception excel');
        $can_pdf = Auth::user()->can('exception pdf');

        return view('exception.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('exception add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Exceptions.');
            if (Auth::user()->can('exception index')) {
                return Redirect::route('exception.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('exception.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExceptionFormRequest $request)
    {

        $exception = new \App\Exception;

        try {
            $exception->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Exceptions ' . $exception->name . ' was added.');

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

        if (!Auth::user()->can('exception view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Exceptions.');
            if (Auth::user()->can('exception index')) {
                return Redirect::route('exception.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($exception = $this->sanitizeAndFind($id)) {
            $statutes = StatuteException::getStatutesForExceptions($exception->id);
            $can_edit = Auth::user()->can('exception edit');
            $can_delete = (Auth::user()->can('exception delete') && $exception->canDelete());
            return view('exception.show', compact('exception','statutes', 'can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Exceptions to display.');
            return Redirect::route('exception.index');
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
        if (!Auth::user()->can('exception edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Exceptions.');
            if (Auth::user()->can('exception index')) {
                return Redirect::route('exception.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($exception = $this->sanitizeAndFind($id)) {
            return view('exception.edit', compact('exception'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Exceptions to edit.');
            return Redirect::route('exception.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Exception $exception     * @return \Illuminate\Http\Response
     */
    public function update(ExceptionFormRequest $request, $id)
    {

//        if (!Auth::user()->can('exception update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Exceptions.');
//            if (!Auth::user()->can('exception index')) {
//                return Redirect::route('exception.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$exception = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Exceptions to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $exception->fill($request->all());

        if ($exception->isDirty()) {

            try {
                $exception->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Exceptions ' . $exception->name . ' was changed.');
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
     * @param  \App\Exception $exception     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('exception delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Exceptions.');
            if (Auth::user()->can('exception index')) {
                 return Redirect::route('exception.index');
            } else {
                return Redirect::route('home');
            }
        }

        $exception = $this->sanitizeAndFind($id);

        if ( $exception  && $exception->canDelete()) {

            try {
                $exception->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Exceptions ' . $exception->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Exceptions to delete.');

        }

        if (Auth::user()->can('exception index')) {
             return Redirect::route('exception.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Exception or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\Exception::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('exception excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Exceptions.');
            if (Auth::user()->can('exception index')) {
                return Redirect::route('exception.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('exception_keyword', '');
        $column = session('exception_column', 'name');
        $direction = session('exception_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Exception::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new ExceptionExport($dataQuery),
            'exception.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('exception export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Exceptions.');
            if (Auth::user()->can('exception index')) {
                return Redirect::route('exception.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('exception_keyword', '');
        $column = session('exception_column', 'name');
        $direction = session('exception_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'section',
            'name',
            'short_name',
            'attorney_note',
            'dyi_note',
            'logic',
        ];
        $dataQuery = Exception::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('exception.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('exception-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
