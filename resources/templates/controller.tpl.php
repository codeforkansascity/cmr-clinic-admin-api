<?php

namespace [[appns]]Http\Controllers;



use [[appns]]Http\Middleware\TrimStrings;
use [[appns]][[model_uc]];
use Illuminate\Http\Request;

use [[appns]]Http\Requests\[[model_uc]]FormRequest;
use [[appns]]Http\Requests\[[model_uc]]IndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\[[model_uc]]Export;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class [[model_uc]]Controller extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-[[view_folder]]/options"
            v-model="[[model_singular]]Selected"
            :selected_id=[[model_singular]]Selected"
            name="[[model_singular]]">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $[[model_singular]]_options = \App\[[model_uc]]::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => '[[model_singular]]_id',
                'selected_id' => $RECORD->[[model_singular]]_id,
                'first_option' => 'Select a [[model_uc_plural]]',
                'options' => $[[model_singular]]_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::findOrCreate('[[model_singular]] index');
             Permission::findOrCreate('[[model_singular]] view');
             Permission::findOrCreate('[[model_singular]] export-pdf');
             Permission::findOrCreate('[[model_singular]] export-excel');
             Permission::findOrCreate('[[model_singular]] add');
             Permission::findOrCreate('[[model_singular]] update');
             Permission::findOrCreate('[[model_singular]] destroy');

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index([[model_uc]]IndexRequest $request)
    {

        if (!Auth::user()->can('[[model_singular]] index')) {
            \Session::flash('flash_error_message', 'You do not have access to [[display_name_singular]]s.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('[[model_singular]]_page', '');
        $search = session('[[model_singular]]_keyword', '');
        $column = session('[[model_singular]]_column', 'Name');
        $direction = session('[[model_singular]]_direction', '-1');

        $can_add = Auth::user()->can('[[model_singular]] add');
        $can_show = Auth::user()->can('[[model_singular]] view');
        $can_edit = Auth::user()->can('[[model_singular]] edit');
        $can_delete = Auth::user()->can('[[model_singular]] delete');
        $can_excel = Auth::user()->can('[[model_singular]] excel');
        $can_pdf = Auth::user()->can('[[model_singular]] pdf');

        return view('[[view_folder]].index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('[[model_singular]] add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a [[display_name_singular]].');
            if (Auth::user()->can('[[model_singular]] index')) {
                return Redirect::route('[[view_folder]].index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('[[view_folder]].create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store([[model_uc]]FormRequest $request)
    {

        $[[model_singular]] = new \App\[[model_uc]];

        try {
            $[[model_singular]]->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', '[[display_name_singular]] ' . $[[model_singular]]->name . ' was added.');

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

        if (!Auth::user()->can('[[model_singular]] view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a [[display_name_singular]].');
            if (Auth::user()->can('[[model_singular]] index')) {
                return Redirect::route('[[view_folder]].index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($[[model_singular]] = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('[[model_singular]] edit');
            $can_delete = (Auth::user()->can('[[model_singular]] delete') && $[[model_singular]]->canDelete());
            return view('[[view_folder]].show', compact('[[model_singular]]','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find [[display_name_singular]] to display.');
            return Redirect::route('[[view_folder]].index');
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
        if (!Auth::user()->can('[[model_singular]] edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a [[display_name_singular]].');
            if (Auth::user()->can('[[model_singular]] index')) {
                return Redirect::route('[[view_folder]].index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($[[model_singular]] = $this->sanitizeAndFind($id)) {
            return view('[[view_folder]].edit', compact('[[model_singular]]'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find [[display_name_singular]] to edit.');
            return Redirect::route('[[view_folder]].index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\[[model_uc]] $[[model_singular]]
     * @return \Illuminate\Http\Response
     */
    public function update([[model_uc]]FormRequest $request, $id)
    {

//        if (!Auth::user()->can('[[model_singular]] update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a [[display_name_singular]].');
//            if (!Auth::user()->can('[[model_singular]] index')) {
//                return Redirect::route('[[view_folder]].index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$[[model_singular]] = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find [[display_name_singular]] to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $[[model_singular]]->fill($request->all());

        if ($[[model_singular]]->isDirty()) {

            try {
                $[[model_singular]]->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', '[[display_name_singular]] ' . $[[model_singular]]->name . ' was changed.');
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
     * @param  \App\[[model_uc]] $[[model_singular]]
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('[[model_singular]] delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a [[display_name_singular]].');
            if (Auth::user()->can('[[model_singular]] index')) {
                 return Redirect::route('[[view_folder]].index');
            } else {
                return Redirect::route('home');
            }
        }

        $[[model_singular]] = $this->sanitizeAndFind($id);

        if ( $[[model_singular]]  && $[[model_singular]]->canDelete()) {

            try {
                $[[model_singular]]->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', '[[display_name_singular]] ' . $[[model_singular]]->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find [[display_name_singular]] to delete.');

        }

        if (Auth::user()->can('[[model_singular]] index')) {
             return Redirect::route('[[view_folder]].index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return [[model_uc]] or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\[[model_uc]]::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('[[model_singular]] excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download [[display_name_plural]].');
            if (Auth::user()->can('[[model_singular]] index')) {
                return Redirect::route('[[view_folder]].index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('[[model_singular]]_keyword', '');
        $column = session('[[model_singular]]_column', 'name');
        $direction = session('[[model_singular]]_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = [[model_uc]]::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new [[model_uc]]Export($dataQuery),
            '[[view_folder]].xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('[[model_singular]] export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print [[display_name_plural]].');
            if (Auth::user()->can('[[model_singular]] index')) {
                return Redirect::route('[[view_folder]].index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('[[model_singular]]_keyword', '');
        $column = session('[[model_singular]]_column', 'name');
        $direction = session('[[model_singular]]_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
[[foreach:grid_columns]]
            '[[i.name]]',
[[endforeach]]
        ];
        $dataQuery = [[model_uc]]::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('[[view_folder]].print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('[[view_folder]]-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
