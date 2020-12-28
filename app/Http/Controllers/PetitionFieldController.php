<?php

namespace App\Http\Controllers;


use App;
use App\Exports\PetitionFieldExport;
use App\Http\Requests\PetitionFieldFormRequest;
use App\Http\Requests\PetitionFieldIndexRequest;
use App\PetitionField;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Session;

//use PDF; // TCPDF, not currently in use

class PetitionFieldController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
     * <ui-select-pick-one
     * url="/api-petition-field/options"
     * v-model="petition_fieldSelected"
     * :selected_id=petition_fieldSelected"
     * name="petition_field">
     * </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
     * $petition_field_options = \App\PetitionField::getOptions();
     *
     *   In View
     *
     * @component('../components/select-pick-one', [
     * 'fld' => 'petition_field_id',
     * 'selected_id' => $RECORD->petition_field_id,
     * 'first_option' => 'Select a PetitionFields',
     * 'options' => $petition_field_options
     * ])
     * @endcomponent
     *
     * Permissions
     *
     *
     * Permission::findOrCreate('petition_field index');
     * Permission::findOrCreate('petition_field view');
     * Permission::findOrCreate('petition_field export-pdf');
     * Permission::findOrCreate('petition_field export-excel');
     * Permission::findOrCreate('petition_field add');
     * Permission::findOrCreate('petition_field update');
     * Permission::findOrCreate('petition_field destroy');
     */


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(PetitionFieldIndexRequest $request)
    {

        if (!Auth::user()->can('petition_field index')) {
            Session::flash('flash_error_message', 'You do not have access to Petition Fieldss.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('petition_field_page', '');
        $search = session('petition_field_keyword', '');
        $column = session('petition_field_column', 'Name');
        $direction = session('petition_field_direction', '-1');

        $can_add = Auth::user()->can('petition_field add');
        $can_show = Auth::user()->can('petition_field view');
        $can_edit = Auth::user()->can('petition_field edit');
        $can_delete = Auth::user()->can('petition_field delete');
        $can_excel = Auth::user()->can('petition_field excel');
        $can_pdf = Auth::user()->can('petition_field pdf');

        return view('petition-field.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        if (!Auth::user()->can('petition_field add')) {  // TODO: add -> create
            Session::flash('flash_error_message', 'You do not have access to add a Petition Fields.');
            if (Auth::user()->can('petition_field index')) {
                return Redirect::route('petition-field.index');
            } else {
                return Redirect::route('home');
            }
        }

        return view('petition-field.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(PetitionFieldFormRequest $request)
    {

        $petition_field = new PetitionField;

        try {
            $record = $petition_field->add($request->validated());
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        Session::flash('flash_success_message', 'Petition Fields ' . $petition_field->name . ' was added.');

        return response()->json([
            'message' => 'Added record',
            'data' => $record
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return Response
     */
    public function show($id)
    {

        if (!Auth::user()->can('petition_field view')) {
            Session::flash('flash_error_message', 'You do not have access to view a Petition Fields.');
            if (Auth::user()->can('petition_field index')) {
                return Redirect::route('petition-field.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($petition_field = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('petition_field edit');
            $can_delete = (Auth::user()->can('petition_field delete') && $petition_field->canDelete());
            return view('petition-field.show', compact('petition_field', 'can_edit', 'can_delete'));
        } else {
            Session::flash('flash_error_message', 'Unable to find Petition Fields to display.');
            return Redirect::route('petition-field.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param integer $id
     * @return Response
     */
    public function edit($id)
    {
        if (!Auth::user()->can('petition_field edit')) {
            Session::flash('flash_error_message', 'You do not have access to edit a Petition Fields.');
            if (Auth::user()->can('petition_field index')) {
                return Redirect::route('petition-field.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($petition_field = $this->sanitizeAndFind($id)) {
            return view('petition-field.edit', compact('petition_field'));
        } else {
            Session::flash('flash_error_message', 'Unable to find Petition Fields to edit.');
            return Redirect::route('petition-field.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PetitionField $petition_field * @return \Illuminate\Http\Response
     */
    public function update(PetitionFieldFormRequest $request, $id)
    {

//        if (!Auth::user()->can('petition_field update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Petition Fields.');
//            if (!Auth::user()->can('petition_field index')) {
//                return Redirect::route('petition-field.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$petition_field = $this->sanitizeAndFind($id)) {
            //     \Session::flash('flash_error_message', 'Unable to find Petition Fields to edit.');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $petition_field->fill($request->all());

        if ($petition_field->isDirty()) {

            try {
                $petition_field->save();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            Session::flash('flash_success_message', 'Petition Fields ' . $petition_field->name . ' was changed.');
        } else {
            Session::flash('flash_info_message', 'No changes were made.');
        }

        return response()->json([
            'message' => 'Changed record'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PetitionField $petition_field * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('petition_field delete')) {
            Session::flash('flash_error_message', 'You do not have access to remove a Petition Fields.');
            if (Auth::user()->can('petition_field index')) {
                return Redirect::route('petition-field.index');
            } else {
                return Redirect::route('home');
            }
        }

        $petition_field = $this->sanitizeAndFind($id);

        if ($petition_field && $petition_field->canDelete()) {

            try {
                $petition_field->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            Session::flash('flash_success_message', 'Petition Fields ' . $petition_field->name . ' was removed.');
        } else {
            Session::flash('flash_error_message', 'Unable to find Petition Fields to delete.');

        }

        if (Auth::user()->can('petition_field index')) {
            return Redirect::route('petition-field.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return PetitionField or null
     */
    private function sanitizeAndFind($id)
    {
        return PetitionField::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('petition_field excel')) {
            Session::flash('flash_error_message', 'You do not have access to download Petition Fields.');
            if (Auth::user()->can('petition_field index')) {
                return Redirect::route('petition-field.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('petition_field_keyword', '');
        $column = session('petition_field_column', 'name');
        $direction = session('petition_field_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = PetitionField::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new PetitionFieldExport($dataQuery),
            'petition-field.xlsx');

    }


    public function print()
    {
        if (!Auth::user()->can('petition_field export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            Session::flash('flash_error_message', 'You do not have access to print Petition Fields.');
            if (Auth::user()->can('petition_field index')) {
                return Redirect::route('petition-field.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('petition_field_keyword', '');
        $column = session('petition_field_column', 'name');
        $direction = session('petition_field_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'applicant_id',
            'petition_number',
            'value',
        ];
        $dataQuery = PetitionField::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('petition-field.print', compact('data'));

        // Begin DOMPDF/laravel-dompdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new DateTime(null, new DateTimeZone('America/Chicago'));
        return $pdf->stream('petition-field-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
