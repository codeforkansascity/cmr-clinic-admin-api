<?php

namespace App\Http\Controllers;

use App;
use App\Exports\StatuteExport;
use App\Http\Requests\StatuteFormRequest;
use App\Http\Requests\StatuteIndexRequest;
use App\Statute;
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

class StatuteController extends Controller
{
    /**
     * Examples.
     *
     * Vue component example.
     *
     * <ui-select-pick-one
     * url="/api-statute/options"
     * v-model="statuteSelected"
     * :selected_id=statuteSelected"
     * name="statute">
     * </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
     * $statute_options = \App\Statute::getOptions();
     *
     *   In View
     *
     * @component('../components/select-pick-one', [
     * 'fld' => 'statute_id',
     * 'selected_id' => $RECORD->statute_id,
     * 'first_option' => 'Select a Statutes',
     * 'options' => $statute_options
     * ])
     * @endcomponent
     *
     * Permissions
     *
     *
     * Permission::create(['name' => 'statute index']);
     * Permission::create(['name' => 'statute add']);
     * Permission::create(['name' => 'statute edit']);
     * Permission::create(['name' => 'statute view']);
     * Permission::create(['name' => 'statute destroy']);
     * Permission::create(['name' => 'statute export-pdf']);
     * Permission::create(['name' => 'statute export-excel']);
     */

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(StatuteIndexRequest $request)
    {
        if (!Auth::user()->can('statute index')) {
            Session::flash('flash_error_message', 'You do not have access to Statutess.');

            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('statute_page', '');
        $search = session('statute_keyword', '');
        $column = session('statute_column', 'Name');
        $direction = session('statute_direction', '-1');

        $can_add = Auth::user()->can('statute add');
        $can_show = Auth::user()->can('statute view');
        $can_edit = Auth::user()->can('statute edit');
        $can_delete = Auth::user()->can('statute delete');
        $can_excel = Auth::user()->can('statute excel');
        $can_pdf = Auth::user()->can('statute pdf');

        return view('statute.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!Auth::user()->can('statute add')) {  // TODO: add -> create
            Session::flash('flash_error_message', 'You do not have access to add a Statutes.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('statute.index');
            } else {
                return Redirect::route('home');
            }
        }

        return view('statute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StatuteFormRequest $request)
    {
        $statute = Statute::create($request->only([
            'number',
            'name',
            'common_name',
            'note',
            'statutes_eligibility_id',
            'superseded_id',
            'superseded_on',
            'jurisdiction_id',
        ]));

        if ($request->statute_exceptions) {
            $this->syncExceptions($request, $statute);
        }

        return response()->json($statute, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        if (!Auth::user()->can('statute view')) {
            Session::flash('flash_error_message', 'You do not have access to view a Statutes.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('statute.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($statute = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('statute edit');
            $can_delete = Auth::user()->can('statute delete') && $statute->canDelete();
            $charges = $statute->getCharges($id);

            $exceptions = $this->create_exceptions($statute);

            return view('statute.show', compact('charges', 'exceptions', 'statute', 'can_edit', 'can_delete'));
        } else {
            Session::flash('flash_error_message', 'Unable to find Statutes to display.');

            return Redirect::route('statute.index');
        }
    }

    private function create_exceptions($statute)
    {
        $exceptions = [];

        if ($statute_exceptions = data_get($statute, 'statute_exceptions', false)) {
            foreach ($statute_exceptions as $statute_exception) {
                if ($exception = data_get($statute_exception, 'exception', false)) {
                    $exceptions[] = [
                        'statute_exception_id' => data_get($statute_exception, 'id', 0),
                        'statute_id' => data_get($statute_exception, 'statute_id', 0),
                        'exception_id' => data_get($statute_exception, 'exception_id', 0),
                        'exception_note' => data_get($statute_exception, 'note', ''),
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
     * @return Response
     */
    public function edit($id)
    {
        if (!Auth::user()->can('statute edit')) {
            Session::flash('flash_error_message', 'You do not have access to edit a Statutes.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('statute.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($statute = $this->sanitizeAndFind($id)) {
            return view('statute.edit', compact('statute'));
        } else {
            Session::flash('flash_error_message', 'Unable to find Statutes to edit.');

            return Redirect::route('statute.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Statute $statute * @return \Illuminate\Http\Response
     */
    public function update(StatuteFormRequest $request, $id)
    {
//        if (!Auth::user()->can('statute edit')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Statutes.');
//            if (!Auth::user()->can('statute index')) {
//                return Redirect::route('statute.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$statute = $this->sanitizeAndFind($id)) {
            //     \Session::flash('flash_error_message', 'Unable to find Statutes to edit');
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        $statute->fill($request->all());


        $originalExceptions = $statute->exceptions;
        $dirtyExceptions = $this->syncExceptions($request, $statute);

        if ($statute->isDirty()) {
            try {
                $statute->save();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request' . $e->getMessage(),
                ], 400);
            }

            Session::flash('flash_success_message', 'Statutes ' . $statute->name . ' was changed');
        } else if ($dirtyExceptions) {
            $statute->saveHistory($request, $originalExceptions);
            Session::flash('flash_success_message', 'Exceptions for Statute' . $statute->name . ' was changed');
        } else {
            Session::flash('flash_info_message', 'No changes were made');
        }

        return response()->json([
            'message' => 'Changed record',
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Statute $statute * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('statute delete')) {
            Session::flash('flash_error_message', 'You do not have access to remove a Statutes.');
            if (Auth::user()->can('statute index')) {
                return Redirect::route('statute.index');
            } else {
                return Redirect::route('home');
            }
        }

        $statute = $this->sanitizeAndFind($id);

        if ($statute && $statute->canDelete()) {
            try {
                $statute->delete();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.',
                ], 400);
            }

            Session::flash('flash_success_message', 'Invitation for ' . $statute->name . ' was removed.');
        } else {
            Session::flash('flash_error_message', 'Unable to find Invite to delete.');
        }

        if (Auth::user()->can('statute index')) {
            return Redirect::route('statute.index');
        } else {
            return Redirect::route('home');
        }
    }

    /**
     * Find by ID, sanitize the ID first.
     *
     * @param $id
     * @return Statute or null
     */
    private function sanitizeAndFind($id)
    {
        return Statute::with([
            'statutes_eligibility',
            'statute_exceptions',
            'jurisdiction',
            'jurisdiction.type',
            'superseded' => function ($q) {
                $q->with('statutes_eligibility');
            },
            'histories' => function ($q) {
                $q->with('user')
                    ->orderBy('created_at', 'asc');
            }
        ])
            ->find(intval($id));
    }

    public function download()
    {
        if (!Auth::user()->can('statute excel')) {
            Session::flash('flash_error_message', 'You do not have access to download Statutes.');
            if (Auth::user()->can('statute index')) {
                return Redirect::route('statute.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('statute_keyword', '');
        $column = session('statute_column', 'name');
        $direction = session('statute_direction', '-1');
        $eligibility_id = session('eligibility_id', '0');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Statute::exportDataQuery($column, $direction, $search, $eligibility_id, ['statutes.id as id',
            'statutes.number as number',
            'statutes.name as name',
            'statutes_eligibilities.name AS eligible',
        ]);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new StatuteExport($dataQuery),
            'statute.xlsx');
    }

    public function print()
    {
        if (!Auth::user()->can('statute export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            Session::flash('flash_error_message', 'You do not have access to print Statutes');
            if (Auth::user()->can('statute index')) {
                return Redirect::route('statute.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('statute_keyword', '');
        $column = session('statute_column', 'name');
        $direction = session('statute_direction', '-1');
        $eligibility_id = session('eligibility_id', '0');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = ['statutes.id as id',
            'statutes.number as number',
            'statutes.name as name',
            'statutes_eligibilities.name AS eligible',
        ];
        $dataQuery = Statute::pdfDataQuery($column, $direction, $search, $eligibility_id, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('statute.print', compact('data'));

        // Begin DOMPDF/laravel-dompdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->loadHTML($printHtml);
        $currentDate = new DateTime(null, new DateTimeZone('America/Chicago'));

        return $pdf->stream('statute-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
        $statutes = Statute::query();
        if ($request->q) {
            $statutes = $statutes->where('number', 'like', $request->q . '%')
                ->limit(20);
        }

        return $statutes->get();
    }

    /**
     * @param $request
     * @param Statute $statute
     * @throws Exception
     */
    private function syncExceptions($request, Statute $statute): bool
    {

        $statute_exceptions = $request->statute_exceptions ?? [];
        $isChanged = false;
        $originals = $statute->statute_exceptions;

        $requestIds = array_filter(
            array_map(function ($exception) {
                return $exception['id'] ?? [];
            },
                $statute_exceptions
            )
        );

        // remove all statute exceptions ids not in the request
        if (!empty($requestIds)) {
            $res = $statute->statute_exceptions()->whereNotIn('id', $requestIds)->delete();
            $isChanged = $res ? true : $isChanged;
        } else if (empty($statute_exceptions)) {
            $statute->statute_exceptions()->delete();
            $isChanged = true;
        }

        // add or update statute exceptions
        foreach ($statute_exceptions as $statute_exception) {
            if (empty($statute_exception['exception_id'])) continue;

            $pivot_id = $statute_exception['id'] ?? null;
            $exception_id = $statute_exception['exception_id'] ?? null;
            if (empty($pivot_id)) {
                $statute->statute_exceptions()->create([
                    'exception_id' => $exception_id,
                    'note' => $statute_exception['note'] ?? ""
                ]);
                $isChanged = true;
            } else {
                $originalException = $originals->firstWhere('id', $pivot_id);
                if (!$originalException || $statute_exception['note'] !== $originalException->note) {
                    $statute->statute_exceptions()
                        ->where('id', $pivot_id)
                        ->update(["note" => $statute_exception['note']]);
                    $isChanged = true;
                }
            }


        }

        return $isChanged;
    }
}
