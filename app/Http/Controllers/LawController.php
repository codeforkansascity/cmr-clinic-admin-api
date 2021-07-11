<?php

namespace App\Http\Controllers;


use App;
use App\Exports\LawExport;
use App\Http\Requests\LawFormRequest;
use App\Http\Requests\LawIndexRequest;
use App\Models\Law;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

//use PDF; // TCPDF, not currently in use

class LawController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(LawIndexRequest $request)
    {

        if (!$request->user()->can('law index')) {
            $request->session()->flash('flash_error_message', 'You do not have access to Laws.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('law_page', '');
        $search = session('law_keyword', '');
        $column = session('law_column', 'number');
        $direction = session('law_direction', '-1');

        $can_add = $request->user()->can('law add');
        $can_show = $request->user()->can('law view');
        $can_edit = $request->user()->can('law edit');
        $can_delete = $request->user()->can('law delete');
        $can_excel = $request->user()->can('law excel');
        $can_pdf = $request->user()->can('law pdf');

        return view('law.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response;
     */
    public function create(Request $request)
    {

        if (!$request->user()->can('law add')) {  // TODO: add -> create
            $request->session()->flash('flash_error_message', 'You do not have access to add a Laws.');
            if ($request->user()->can('law index')) {
                return Redirect::route('law.index');
            } else {
                return Redirect::route('home');
            }
        }

        return view('law.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @paramRequest $request
     * @return Response;
     */
    public function store(LawFormRequest $request)
    {

        $law = new Law;

        try {
            $law->add($request->validated());
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unable to process request',
            ], 400);
        }

        $request->session()->flash('flash_success_message', 'Laws ' . $law->name . ' was added.');

        return response()->json([
            'message' => 'Added record',
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return Response
     */
    public function show(Request $request, $id)
    {

        if (!$request->user()->can('law view')) {
            $request->session()->flash('flash_error_message', 'You do not have access to view a Laws.');
            if ($request->user()->can('law index')) {
                return Redirect::route('law.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($law = Law::sanitizeAndFind($id)) {

            $can_edit = $request->user()->can('law edit');
            $can_delete = ($request->user()->can('law delete') && $law->canDelete());

            $charges = Law::getCharges($id);
            $charges = [];
            $exceptions = $this->create_exceptions($law);
            $versions = App\Models\LawVersion::getNonApprovedVersions($law->id);

            return view('law.show', compact('law', 'charges', 'exceptions', 'versions', 'can_edit', 'can_delete'));
        } else {
            $request->session()->flash('flash_error_message', 'Unable to find Laws to display.');
            return Redirect::route('law.index');
        }
    }

    private function create_exceptions($law_version)
    {
        $exceptions = [];

        if ($law_version_exceptions = data_get($law_version, 'law_version_exceptions', false)) {
            foreach ($law_version_exceptions as $law_version_exception) {
                if ($exception = data_get($law_version_exception, 'exception', false)) {
                    $exceptions[] = [
                        'statute_exception_id' => data_get($law_version_exception, 'id', 0),
                        'statute_id' => data_get($law_version_exception, 'statute_id', 0),
                        'exception_id' => data_get($law_version_exception, 'exception_id', 0),
                        'exception_note' => data_get($law_version_exception, 'note', ''),
                        'exception_section' => data_get($exception, 'section', 'ERR S'),
                        'exception_name' => data_get($exception, 'name', 'ERR N'),
                        'exception_attorney_note' => data_get($exception, 'attorney_note', 'ERR N'),
                        'exception_dyi_note' => data_get($exception, 'dyi_note', 'ERR N'),
                        'exception_logic' => data_get($exception, 'logic', 'ERR N'),
                        'exception_short_name' => data_get($exception, 'short_name', 'ERR SN'),
                    ];
                }
            }
        }

        return $exceptions;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response;
     */
    public function edit(Request $request, $id)
    {
        if (!$request->user()->can('law edit')) {
            $request->session()->flash('flash_error_message', 'You do not have access to edit a Laws.');
            if ($request->user()->can('law index')) {
                return Redirect::route('law.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($law = Law::sanitizeAndFind($id)) {
            return view('law.edit', compact('law'));
        } else {
            $request->session()->flash('flash_error_message', 'Unable to find Laws to edit.');
            return Redirect::route('law.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Law $law * @return Response;
     */
    public function update(LawFormRequest $request, $id)
    {

//        if (!$request->user()->can('law update')) {
//            $request->session()->flash('flash_error_message', 'You do not have access to update a Laws.');
//            if (!$request->user()->can('law index')) {
//                return Redirect::route('law.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$law = Law::sanitizeAndFind($id)) {
            //     $request->session()->flash('flash_error_message', 'Unable to find Laws to edit.');
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        $law->fill($request->all());

        if ($law->isDirty()) {

            try {
                $law->save();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request',
                ], 400);
            }

            $request->session()->flash('flash_success_message', 'Laws ' . $law->name . ' was changed.');
        } else {
            $request->session()->flash('flash_info_message', 'No changes were made.');
        }

        return response()->json([
            'message' => 'Changed record',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Law $law * @return Response;
     */
    public function destroy(Request $request, $id)
    {

        if (!$request->user()->can('law delete')) {
            $request->session()->flash('flash_error_message', 'You do not have access to remove a Laws.');
            if ($request->user()->can('law index')) {
                return Redirect::route('law.index');
            } else {
                return Redirect::route('home');
            }
        }

        $law = Law::sanitizeAndFind($id);

        if ($law && $law->canDelete()) {

            try {
                $law->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.',
                ], 400);
            }

            $request->session()->flash('flash_success_message', 'Laws ' . $law->name . ' was removed.');
        } else {
            $request->session()->flash('flash_error_message', 'Unable to find Laws to delete.');

        }

        if ($request->user()->can('law index')) {
            return Redirect::route('law.index');
        } else {
            return Redirect::route('home');
        }


    }


    public function download(Request $request)
    {
        if (!$request->user()->can('law excel')) {
            $request->session()->flash('flash_error_message', 'You do not have access to download Laws.');
            if ($request->user()->can('law index')) {
                return Redirect::route('law.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('law_keyword', '');
        $column = session('law_column', 'name');
        $direction = session('law_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Law::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new LawExport($dataQuery),
            'law.xlsx');

    }


    public function print(Request $request)
    {
        if (!$request->user()->can('law export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            $request->session()->flash('flash_error_message', 'You do not have access to print Laws.');
            if ($request->user()->can('law index')) {
                return Redirect::route('law.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('law_keyword', '');
        $column = session('law_column', 'name');
        $direction = session('law_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
        ];
        $dataQuery = Law::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('law.print', compact('data'));

        // Begin DOMPDF/laravel-dompdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->loadHTML($printHtml);
        $currentDate = new DateTime(null, new DateTimeZone('America/Chicago'));
        return $pdf->stream('law-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
