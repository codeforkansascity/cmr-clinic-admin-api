<?php

namespace App\Http\Controllers;


use App;
use App\Exports\LawVersionExport;
use App\Http\Requests\LawVersionFormRequest;
use App\Http\Requests\LawVersionIndexRequest;
use App\Models\LawVersion;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

//use PDF; // TCPDF, not currently in use

class LawVersionController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(LawVersionIndexRequest $request)
    {

        if (!$request->user()->can('law_version index')) {
            $request->session()->flash('flash_error_message', 'You do not have access to Law Versions.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('law_version_page', '');
        $search = session('law_version_keyword', '');
        $column = session('law_version_column', 'Name');
        $direction = session('law_version_direction', '-1');

        $can_add = $request->user()->can('law_version add');
        $can_show = $request->user()->can('law_version view');
        $can_edit = $request->user()->can('law_version edit');
        $can_delete = $request->user()->can('law_version delete');
        $can_excel = $request->user()->can('law_version excel');
        $can_pdf = $request->user()->can('law_version pdf');

        return view('law-version.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response;
     */
    public function create(Request $request)
    {

        if (!$request->user()->can('law_version add')) {  // TODO: add -> create
            $request->session()->flash('flash_error_message', 'You do not have access to add a Law Versions.');
            if ($request->user()->can('law_version index')) {
                return Redirect::route('law-version.index');
            } else {
                return Redirect::route('home');
            }
        }


        $version_id = intval(data_get($request,'version_id',-1));

        if ($law_version = LawVersion::sanitizeAndFind($version_id)) {
            $law_version->based_on_law_version_id = $law_version->id;
            $law_version->id = 0;
            $law_version->verison_status = LawVersion::REQUESTED;

            $exceptions = $this->create_exceptions($law_version);

            return view('law-version.create', compact('law_version','exceptions'));
        } else {
            $request->session()->flash('flash_error_message', 'Unable to find Law Versions to edit.');
            return Redirect::route('law-version.index');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @paramRequest $request
     * @return Response;
     */
    public function store(LawVersionFormRequest $request)
    {





        try {
            $attributes = $request->validated();

            $attributes['version_status'] = LawVersion::REQUESTED;

            $law_version = LawVersion::create($attributes);


            if ($request->law_version_exceptions) {
                $this->syncExceptions($request, $law_version, $law_version_id = $law_version->id);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unable to process request',
            ], 400);
        }

        $request->session()->flash('flash_success_message', 'Law Versions ' . $law_version->name . ' was added.');

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

        if (!$request->user()->can('law_version view')) {
            $request->session()->flash('flash_error_message', 'You do not have access to view a Law Versions.');
            if ($request->user()->can('law_version index')) {
                return Redirect::route('law-version.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($law_version = LawVersion::sanitizeAndFind($id)) {
            $can_edit = $request->user()->can('law_version edit');
            $can_delete = ($request->user()->can('law_version delete') && $law_version->canDelete());
            $exceptions = $this->create_exceptions($law_version);
            return view('law-version.show', compact('law_version', 'exceptions', 'can_edit', 'can_delete'));
        } else {
            $request->session()->flash('flash_error_message', 'Unable to find Law Versions to display.');
            return Redirect::route('law-version.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response;
     */
    public function edit(Request $request, $id)
    {
        if (!$request->user()->can('law_version edit')) {
            $request->session()->flash('flash_error_message', 'You do not have access to edit a Law Versions.');
            if ($request->user()->can('law_version index')) {
                return Redirect::route('law-version.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($law_version = LawVersion::sanitizeAndFind($id)) {
            return view('law-version.edit', compact('law_version'));
        } else {
            $request->session()->flash('flash_error_message', 'Unable to find Law Versions to edit.');
            return Redirect::route('law-version.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\LawVersion $law_version * @return Response;
     */
    public function update(LawVersionFormRequest $request, $id)
    {

//        if (!$request->user()->can('law_version update')) {
//            $request->session()->flash('flash_error_message', 'You do not have access to update a Law Versions.');
//            if (!$request->user()->can('law_version index')) {
//                return Redirect::route('law-version.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$law_version = LawVersion::sanitizeAndFind($id)) {
            //     $request->session()->flash('flash_error_message', 'Unable to find Law Versions to edit.');
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        $law_version->fill($request->all());

        if ($law_version->isDirty()) {

            try {
                $law_version->save();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request',
                ], 400);
            }

            $request->session()->flash('flash_success_message', 'Law Versions ' . $law_version->name . ' was changed.');
        } else {
            $request->session()->flash('flash_info_message', 'No changes were made.');
        }

        return response()->json([
            'message' => 'Changed record',
        ], 200);
    }

    public function approve(Request $request,$id) {
        if (!$request->user()->can('law_version edit')) {
            $request->session()->flash('flash_error_message', 'You do not have access to approve a Law Versions.');
            if ($request->user()->can('law index')) {
                return Redirect::route('law.index');
            } else {
                return Redirect::route('home');
            }
        }


        if ($changed_law_version = LawVersion::sanitizeAndFind($id)) {
            if ($current_law_version = LawVersion::sanitizeAndFind($changed_law_version->based_on_law_version_id)) {
                DB::beginTransaction();
                $law = App\Models\Law::find($changed_law_version->law_id);
                $law->law_version_id = $changed_law_version->id;
                $law->save();


                $now = Carbon::now();

                $changed_law_version->version_status = LawVersion::APPROVED;
                $changed_law_version->start_date = $now;
                $changed_law_version->save();

                $current_law_version->end_date = $now;
                $current_law_version->save();

                DB::commit();

                $request->session()->flash('flash_success_message', 'Law Versions ' . $changed_law_version->number . ' ' . $changed_law_version->name . ' was approved.');
                return Redirect::route('law.index');
            } else {
                $request->session()->flash('flash_error_message', 'Unable to find Law Versions to edit.');
                return Redirect::route('law.index');
            }

        } else {
            $request->session()->flash('flash_error_message', 'Unable to find Law Versions to edit.');
            return Redirect::route('law.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\LawVersion $law_version * @return Response;
     */
    public function destroy(Request $request, $id)
    {

        if (!$request->user()->can('law_version delete')) {
            $request->session()->flash('flash_error_message', 'You do not have access to remove a Law Versions.');
            if ($request->user()->can('law_version index')) {
                return Redirect::route('law-version.index');
            } else {
                return Redirect::route('home');
            }
        }

        $law_version = LawVersion::sanitizeAndFind($id);

        if ($law_version && $law_version->canDelete()) {

            try {
                $law_version->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.',
                ], 400);
            }

            $request->session()->flash('flash_success_message', 'Law Versions ' . $law_version->name . ' was removed.');
        } else {
            $request->session()->flash('flash_error_message', 'Unable to find Law Versions to delete.');

        }

        if ($request->user()->can('law_version index')) {
            return Redirect::route('law-version.index');
        } else {
            return Redirect::route('home');
        }


    }



    public function download(Request $request)
    {
        if (!$request->user()->can('law_version excel')) {
            $request->session()->flash('flash_error_message', 'You do not have access to download Law Versions.');
            if ($request->user()->can('law_version index')) {
                return Redirect::route('law-version.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('law_version_keyword', '');
        $column = session('law_version_column', 'name');
        $direction = session('law_version_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = LawVersion::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new LawVersionExport($dataQuery),
            'law-version.xlsx');

    }


    public function print(Request $request)
    {
        if (!$request->user()->can('law_version export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            $request->session()->flash('flash_error_message', 'You do not have access to print Law Versions.');
            if ($request->user()->can('law_version index')) {
                return Redirect::route('law-version.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('law_version_keyword', '');
        $column = session('law_version_column', 'name');
        $direction = session('law_version_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'number',
            'name',
        ];
        $dataQuery = LawVersion::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('law-version.print', compact('data'));

        // Begin DOMPDF/laravel-dompdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->loadHTML($printHtml);
        $currentDate = new DateTime(null, new DateTimeZone('America/Chicago'));
        return $pdf->stream('law-version-' . $currentDate->format('Ymd_Hi') . '.pdf');

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

    private function syncExceptions($request, LawVersion $law_version, $law_version_id=null): bool
    {

        $law_version_exceptions = $request->law_version_exceptions ?? [];
        $isChanged = false;
        $originals = $law_version->law_version_exceptions;

        $requestIds = array_filter(
            array_map(function ($exception) {
                return $exception['id'] ?? [];
            },
                $law_version_exceptions
            )
        );

        // remove all law_version exceptions ids not in the request
        if (!empty($requestIds)) {
            $res = $law_version->law_version_exceptions()->whereNotIn('id', $requestIds)->delete();
            $isChanged = $res ? true : $isChanged;
        } else if (empty($law_version_exceptions)) {
            $law_version->law_version_exceptions()->delete();
            $isChanged = true;
        }

        // add or update law_version exceptions
        foreach ($law_version_exceptions as $law_version_exception) {
            if (empty($law_version_exception['exception_id'])) continue;

            $pivot_id = $law_version_exception['id'] ?? null;

            if ($law_version_id) {
                $pivot_id = null;
            }


            $exception_id = $law_version_exception['exception_id'] ?? null;
            if (empty($pivot_id)) {
                $attributes = [
                    'exception_id' => $exception_id,

                    'note' => $law_version_exception['note'] ?? ""
                ];
                if ($law_version_id) {
                    $attributes['law_version_id'] = $law_version_id;
                }

                info(__METHOD__);
            //    info(print_r($attributes,true));
                $law_version->law_version_exceptions()->create($attributes);
                $isChanged = true;
            } else {
                $originalException = $originals->firstWhere('id', $pivot_id);
                if (!$originalException || $law_version_exception['note'] !== $originalException->note) {
                    $law_version->law_version_exceptions()
                        ->where('id', $pivot_id)
                        ->update(["note" => $law_version_exception['note']]);
                    $isChanged = true;
                }
            }


        }

        return $isChanged;
    }

}
