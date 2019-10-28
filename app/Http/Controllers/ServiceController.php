<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\Service;
use Illuminate\Http\Request;

use App\Http\Requests\ServiceFormRequest;
use App\Http\Requests\ServiceIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\ServiceExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class ServiceController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-service/options"
            v-model="serviceSelected"
            :selected_id=serviceSelected"
            name="service">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $service_options = \App\Service::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'service_id',
                'selected_id' => $RECORD->service_id,
                'first_option' => 'Select a Services',
                'options' => $service_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::findOrCreate('service index');
             Permission::findOrCreate('service view');
             Permission::findOrCreate('service export-pdf');
             Permission::findOrCreate('service export-excel');
             Permission::findOrCreate('service add');
             Permission::findOrCreate('service edit');
             Permission::findOrCreate('service delete');

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ServiceIndexRequest $request)
    {

        if (!Auth::user()->can('service index')) {
            \Session::flash('flash_error_message', 'You do not have access to Servicess.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('service_page', '');
        $search = session('service_keyword', '');
        $column = session('service_column', 'name');
        $direction = session('service_direction', '-1');

        $can_add = Auth::user()->can('service add');
        $can_show = Auth::user()->can('service view');
        $can_edit = Auth::user()->can('service edit');
        $can_delete = Auth::user()->can('service delete');
        $can_excel = Auth::user()->can('service excel');
        $can_pdf = Auth::user()->can('service pdf');

        return view('service.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('service add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Services.');
            if (Auth::user()->can('service index')) {
                return Redirect::route('service.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('service.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceFormRequest $request)
    {

        $service = new \App\Service;

        try {
            $service->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Services ' . $service->name . ' was added.');

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

        if (!Auth::user()->can('service view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Services.');
            if (Auth::user()->can('service index')) {
                return Redirect::route('service.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($service = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('service edit');
            $can_delete = (Auth::user()->can('service delete') && $service->canDelete());
            return view('service.show', compact('service','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Services to display.');
            return Redirect::route('service.index');
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
        if (!Auth::user()->can('service edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Services.');
            if (Auth::user()->can('service index')) {
                return Redirect::route('service.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($service = $this->sanitizeAndFind($id)) {
            return view('service.edit', compact('service'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Services to edit.');
            return Redirect::route('service.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Service $service     * @return \Illuminate\Http\Response
     */
    public function update(ServiceFormRequest $request, $id)
    {

//        if (!Auth::user()->can('service update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Services.');
//            if (!Auth::user()->can('service index')) {
//                return Redirect::route('service.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$service = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Services to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $service->fill($request->all());

        if ($service->isDirty()) {

            try {
                $service->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Services ' . $service->name . ' was changed.');
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
     * @param  \App\Service $service     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('service delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Services.');
            if (Auth::user()->can('service index')) {
                 return Redirect::route('service.index');
            } else {
                return Redirect::route('home');
            }
        }

        $service = $this->sanitizeAndFind($id);

        if ( $service  && $service->canDelete()) {

            try {
                $service->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Services ' . $service->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Services to delete.');

        }

        if (Auth::user()->can('service index')) {
             return Redirect::route('service.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Service or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\Service::with('service_type')->find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('service excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Services.');
            if (Auth::user()->can('service index')) {
                return Redirect::route('service.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('service_keyword', '');
        $column = session('service_column', 'name');
        $direction = session('service_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Service::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new ServiceExport($dataQuery),
            'service.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('service export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Services.');
            if (Auth::user()->can('service index')) {
                return Redirect::route('service.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('service_keyword', '');
        $column = session('service_column', 'name');
        $direction = session('service_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
            'service_type_id',
        ];
        $dataQuery = Service::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('service.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('service-' . $currentDate->format('Ymd_Hi') . '.pdf');

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

    public function all(Request $request)
    {

        $services =  Service::query();
        if($request->q) {
            $services = $services->where('name', 'like', '%'.$request->q.'%')
                ->limit(20);
        }
        return $services->get();
    }

}
