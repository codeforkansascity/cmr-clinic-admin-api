<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\ServiceType;
use Illuminate\Http\Request;

use App\Http\Requests\ServiceTypeFormRequest;
use App\Http\Requests\ServiceTypeIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\ServiceTypeExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class ServiceTypeController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-service-type/options"
            v-model="service_typeSelected"
            :selected_id=service_typeSelected"
            name="service_type">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $service_type_options = \App\ServiceType::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'service_type_id',
                'selected_id' => $RECORD->service_type_id,
                'first_option' => 'Select a ServiceTypes',
                'options' => $service_type_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::findOrCreate('service_type index');
             Permission::findOrCreate('service_type view');
             Permission::findOrCreate('service_type export-pdf');
             Permission::findOrCreate('service_type export-excel');
             Permission::findOrCreate('service_type add');
             Permission::findOrCreate('service_type edit');
             Permission::findOrCreate('service_type delete');

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ServiceTypeIndexRequest $request)
    {

        if (!Auth::user()->can('service_type index')) {
            \Session::flash('flash_error_message', 'You do not have access to Service Typess.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('service_type_page', '');
        $search = session('service_type_keyword', '');
        $column = session('service_type_column', 'Name');
        $direction = session('service_type_direction', '-1');

        $can_add = Auth::user()->can('service_type add');
        $can_show = Auth::user()->can('service_type view');
        $can_edit = Auth::user()->can('service_type edit');
        $can_delete = Auth::user()->can('service_type delete');
        $can_excel = Auth::user()->can('service_type excel');
        $can_pdf = Auth::user()->can('service_type pdf');

        return view('service-type.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('service_type add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Service Types.');
            if (Auth::user()->can('service_type index')) {
                return Redirect::route('service-type.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('service-type.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceTypeFormRequest $request)
    {

        $service_type = new \App\ServiceType;

        try {
            $service_type->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Service Types ' . $service_type->name . ' was added.');

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

        if (!Auth::user()->can('service_type view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Service Types.');
            if (Auth::user()->can('service_type index')) {
                return Redirect::route('service-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($service_type = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('service_type edit');
            $can_delete = (Auth::user()->can('service_type delete') && $service_type->canDelete());
            return view('service-type.show', compact('service_type','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Service Types to display.');
            return Redirect::route('service-type.index');
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
        if (!Auth::user()->can('service_type edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Service Types.');
            if (Auth::user()->can('service_type index')) {
                return Redirect::route('service-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($service_type = $this->sanitizeAndFind($id)) {
            return view('service-type.edit', compact('service_type'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Service Types to edit.');
            return Redirect::route('service-type.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ServiceType $service_type     * @return \Illuminate\Http\Response
     */
    public function update(ServiceTypeFormRequest $request, $id)
    {

//        if (!Auth::user()->can('service_type update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Service Types.');
//            if (!Auth::user()->can('service_type index')) {
//                return Redirect::route('service-type.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$service_type = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Service Types to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $service_type->fill($request->all());

        if ($service_type->isDirty()) {

            try {
                $service_type->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Service Types ' . $service_type->name . ' was changed.');
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
     * @param  \App\ServiceType $service_type     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('service_type delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Service Types.');
            if (Auth::user()->can('service_type index')) {
                 return Redirect::route('service-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        $service_type = $this->sanitizeAndFind($id);

        if ( $service_type  && $service_type->canDelete()) {

            try {
                $service_type->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Service Types ' . $service_type->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Service Types to delete.');

        }

        if (Auth::user()->can('service_type index')) {
             return Redirect::route('service-type.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return ServiceType or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\ServiceType::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('service_type excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Service Types.');
            if (Auth::user()->can('service_type index')) {
                return Redirect::route('service-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('service_type_keyword', '');
        $column = session('service_type_column', 'name');
        $direction = session('service_type_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = ServiceType::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new ServiceTypeExport($dataQuery),
            'service-type.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('service_type export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Service Types.');
            if (Auth::user()->can('service_type index')) {
                return Redirect::route('service-type.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('service_type_keyword', '');
        $column = session('service_type_column', 'name');
        $direction = session('service_type_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
        ];
        $dataQuery = ServiceType::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('service-type.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('service-type-' . $currentDate->format('Ymd_Hi') . '.pdf');

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

    public function all()
    {

        $service_type =  ServiceType::query();

        return $service_type->get();
    }
}
