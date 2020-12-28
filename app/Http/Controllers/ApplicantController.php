<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Exports\ApplicantExport;
use App\Http\Requests\ApplicantFormRequest;
use App\Http\Requests\ApplicantIndexRequest;
use App\Lib\AddApplicantFromCriminalHistory;
use App\Lib\ApplicantHistoryUploader;
use App\Lib\GetCriminalHistoryFromSS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

//use PDF; // TCPDF, not currently in use

class ApplicantController extends Controller
{
    /**
     * Examples.
     *
     * Vue component example.
     *
     * <ui-select-pick-one
     * url="/api-applicant/options"
     * v-model="applicantSelected"
     * :selected_id=applicantSelected"
     * name="applicant">
     * </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
     * $applicant_options = \App\Applicant::getOptions();
     *
     *   In View
     *
     * @component('../components/select-pick-one', [
     * 'fld' => 'applicant_id',
     * 'selected_id' => $RECORD->applicant_id,
     * 'first_option' => 'Select a Applicants',
     * 'options' => $applicant_options
     * ])
     * @endcomponent
     *
     * Permissions
     *
     *
     * Permission::findOrCreate('applicant index');
     * Permission::findOrCreate('applicant view');
     * Permission::findOrCreate('applicant export-pdf');
     * Permission::findOrCreate('applicant export-excel');
     * Permission::findOrCreate('applicant add');
     * Permission::findOrCreate('applicant edit');
     * Permission::findOrCreate('applicant delete');
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ApplicantIndexRequest $request)
    {
        if (!Auth::user()->can('applicant index')) {
            \Session::flash('flash_error_message', 'You do not have access to Applicantss.');

            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('applicant_page', '');
        $search = session('applicant_keyword', '');
        $column = session('applicant_column', 'applicant_name');
        $direction = session('applicant_direction', '-1');
        $status_id = session('status_id', '0');
        $assignment_id = session('assignment_id', Auth::id());

        $can_access_all = Auth::user()->can('applicant access-all');
        $can_add = Auth::user()->can('applicant add');
        $can_show = Auth::user()->can('applicant view');
        $can_edit = Auth::user()->can('applicant edit');
        $can_delete = Auth::user()->can('applicant delete');
        $can_excel = Auth::user()->can('applicant excel');
        $can_pdf = Auth::user()->can('applicant pdf');

        info(__METHOD__);
        info($can_add);
        info($can_edit);

        return view('applicant.index', compact('page', 'column', 'direction', 'search', 'status_id', 'assignment_id', 'can_access_all', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        if (!Auth::user()->can('applicant add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Applicants.');
            if (Auth::user()->can('applicant index')) {
                return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        return view('applicant.add');
    }

    public function file_upload(Request $request)
    {
        info(__METHOD__ . print_r($request->all(), true));
        $uploader = new ApplicantHistoryUploader();
        $uploader->saveUploadedFile('vc_vendor_id', $request->work_order_log_id, $request->display_name, '/download/vendor-logo/', $request->filename);
    }

    public function add_from_ss(Request $request)
    {
        info(__METHOD__ . print_r($request->all(), true));

        $data = [];

        $path = env('APPLICANT_HISTORIES_DIRECTORY', 'applicant_histories');

        $ss = new GetCriminalHistoryFromSS($path, '/' . $request->local_file_name, $data);
//        try {
        $data = $ss->processSpreadSheet();
        info(print_r($data, true));

        $criminal_history = new AddApplicantFromCriminalHistory($data);
        $add = $criminal_history->addHistory();
        info(print_r($add, true));
//        } catch (\Exception $e) {
//            print $e->getMessage() . "\n";
//
//        }

        if (empty($add['errors'])) {
            return response()->json([
                'message' => 'Added record',
                'warnings' => $add['warnings'],
                'errors' => $add['errors'],
                'record' => $add['record'],
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unable to add record',
                'warnings' => $add['warnings'],
                'errors' => $add['errors'],
                'record' => $add['record'],
            ], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('applicant add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Applicants.');
            if (Auth::user()->can('applicant index')) {
                return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        $can_cms = Auth::user()->can('CMS access');

        return view('applicant.create', compact('can_cms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicantFormRequest $request)
    {
        $applicant = new \App\Applicant;

        try {
            $applicant->add($request->validated());
            $data = $applicant->toArray();
            info(print_r($data, true));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request',
            ], 400);
        }

        \Session::flash('flash_success_message', 'Applicants ' . $applicant->name . ' was added.');

        return response()->json([
            'message' => 'Added record',
            'record' => $data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        info(__METHOD__);

        if (!Auth::user()->can('applicant view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Applicants.');
            if (Auth::user()->can('applicant index')) {
                return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($applicant = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('applicant edit');
            $can_delete = (Auth::user()->can('applicant delete') && $applicant->canDelete());
            $can_cms = Auth::user()->can('CMS access');

            return view('applicant.show', compact('applicant', 'can_edit', 'can_delete', 'can_cms'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Applicants to display.');

            return Redirect::route('applicant.index');
        }
    }

    /**
     * Find by ID, sanitize the ID first.
     *
     * @param $id
     * @return Applicant or null
     */
    private
    function sanitizeAndFind($id)
    {
        return \App\Applicant::with([
            'conviction' => function ($q) {
                $q->orderBy('release_date', 'desc');
            },
            'conviction.services' => function ($q) {
                $q->with('service_type');
            },
            'conviction.charge',
            'conviction.charge.statute.jurisdiction',
            'conviction.charge.statute.jurisdiction.type',
            'conviction.charge.statute',
            'conviction.charge.statute.statutes_eligibility',
            'conviction.charge.statute.superseded',
            //'conviction.charge.statute.superseded.statutes_eligibility',
            'assignment',
            'step',
            'status',
            'conviction.sources',
            'cdl_status'
        ])->find(intval($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->can('applicant edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Applicants.');
            if (Auth::user()->can('applicant index')) {
                return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($applicant = $this->sanitizeAndFind($id)) {
            $can_cms = Auth::user()->can('CMS access');
            return view('applicant.edit', compact('applicant', 'can_cms'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Applicants to edit.');

            return Redirect::route('applicant.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Applicant $applicant * @return \Illuminate\Http\Response
     */
    public function update(ApplicantFormRequest $request, $id)
    {

//        if (!Auth::user()->can('applicant edit')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Applicants.');
//            if (!Auth::user()->can('applicant index')) {
//                return Redirect::route('applicant.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$applicant = $this->sanitizeAndFind($id)) {
            //     \Session::flash('flash_error_message', 'Unable to find Applicants to edit.');
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        $applicant->fill($request->all());

        if ($applicant->isDirty()) {
            try {
                $applicant->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request',
                ], 400);
            }

            \Session::flash('flash_success_message', 'Applicants ' . $applicant->name . ' was changed.');
        } else {
            \Session::flash('flash_info_message', 'No changes were made.');
        }

        return response()->json([
            'message' => 'Changed record',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function preview($id)
    {
        info(__METHOD__);

        if (!Auth::user()->can('applicant view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Applicants.');
            if (Auth::user()->can('applicant index')) {
                return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($applicant = $this->sanitizeAndFind($id)) {

            $expungebles = $this->getExpungebles($applicant->conviction);
            $expungebles = $this->transformExpungebles($expungebles);
            $not_selected_to_expunge = $this->getNotExpungebles($applicant->conviction);
            $service_list = $this->getServiceList($applicant->conviction);

            $can_edit = Auth::user()->can('applicant edit');
            $can_delete = (Auth::user()->can('applicant delete') && $applicant->canDelete());

            return view('applicant.preview', compact('applicant', 'expungebles', 'not_selected_to_expunge', 'service_list', 'can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Applicants to display.');

            return Redirect::route('applicant.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function petition($id)
    {
        info(__METHOD__);

        if (!Auth::user()->can('applicant view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Applicants.');
            if (Auth::user()->can('applicant index')) {
                return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($applicant = $this->sanitizeAndFind($id)) {

            $expungebles = $this->getExpungebles($applicant->conviction);
            $expungebles = $this->transformExpungebles($expungebles);

            $petition_count=  count($expungebles);
            $group_count=  count($expungebles[1]);
            $case_count=  2; // count($expungebles[1][1]);
            $service_list = $this->getServiceList($applicant->conviction);
            $can_edit = Auth::user()->can('applicant edit');
            $can_delete = (Auth::user()->can('applicant delete') && $applicant->canDelete());

            return view('applicant.petition', compact('applicant',
                'expungebles', 'service_list', 'can_edit', 'can_delete', 'petition_count', 'group_count', 'case_count'
            ));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Applicants to display.');

            return Redirect::route('applicant.index');
        }
    }

    private function getExpungebles($convictions)
    {

        $to_expunge = [];
        foreach ($convictions AS $conviction) {
            if ($conviction->charge->count()) {
                foreach ($conviction->charge AS $charge) {


                    if ($charge->please_expunge) {

                        $key = $charge->petition_number . ':';
                        $key .= $charge->group_number . ':';
                        $key .= $charge->group_sequence . ':';
                        $key .= $charge->id;

                        $to_expunge[$key] = []; //$charge->toArray();
                        $to_expunge[$key]['statue_number'] = $charge->statute->number;
                        $to_expunge[$key]['statue_name'] = $charge->statute->name;
                        $to_expunge[$key]['case_number'] = $conviction->case_number;
                        $to_expunge[$key]['date_of_charge'] = $conviction->date_of_charge;
                        $to_expunge[$key]['group_sequence'] =$charge->group_sequence;

                    }
                }
            }
        }
        ksort($to_expunge);
        return $to_expunge;
    }

    private function transformExpungebles($expungebles) {

        $data[1] = [];

        foreach ($expungebles AS $key => $record ) {
            list($petition, $group, $seq, $id ) = explode(':',$key);
            if (!array_key_exists($petition,$data)) {
                $data[$petition] = [];
            }
            if (!array_key_exists($group,$data[$petition])) {
                $data[$petition][$group] = [];
            }
            $data[$petition][$group][] = $record;
        }



        return $data;

    }

    private function getNotExpungebles($convictions)
    {

        $not_selected = [];
        foreach ($convictions AS $conviction) {

            if ($conviction->charge->count()) {
                foreach ($conviction->charge AS $charge) {
                    if ($charge->please_expunge != 1) {
                        $key = $conviction->case_number . ':';
                        $key .= $charge->id;
                        $not_selected[$key] = [];
                        $not_selected[$key]['statue_number'] = data_get($charge->statute, 'number', '***');
                        $not_selected[$key]['statue_name'] = data_get($charge->statute, 'name', '***');
                        $not_selected[$key]['case_number'] = data_get($conviction, 'case_number' ,'***');
                        $not_selected[$key]['convicted'] = data_get($conviction, 'convicted', false) ? 'Convicted' : 'Not Convicted';
                        $not_selected[$key]['eligible'] = data_get($conviction, 'eligible', false) ? 'Eligible' : 'Not Eligible';
                        $not_selected[$key]['date_of_charge'] = data_get($conviction,'date_of_charge', '0000-00-00');

                    }
                }
            }
        }
        ksort($not_selected);
        return $not_selected;
    }

    private function getServiceList($convictions)
    {

        $service_list = [];
        foreach ($convictions AS $conviction) {

            if ($conviction->services->count()) {
                foreach ($conviction->services AS $service) {
                    $key = $service->id;
                    $service_list[$key]['name'] = $service->name;
                    $service_list[$key]['address'] = $service->address;
                    $service_list[$key]['address_line_2'] = $service->address_line_2;
                    $service_list[$key]['city'] = $service->city;
                    $service_list[$key]['state'] = $service->state;
                    $service_list[$key]['zip'] = $service->zip;
                }
            }
        }
        ksort($service_list);
        return $service_list;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Applicant $applicant * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        if (!Auth::user()->can('applicant delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Applicants.');
            if (Auth::user()->can('applicant index')) {
                return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        $applicant = $this->sanitizeAndFind($id);

        if ($applicant && $applicant->canDelete()) {
            try {
                $applicant->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.',
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Unable to find Applicants to delete.',
            ], 404);
        }

        return response()->json('Success', 200);
    }

    public
    function download()
    {
        if (!Auth::user()->can('applicant excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Applicants.');
            if (Auth::user()->can('applicant index')) {
                return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('applicant_keyword', '');
        $column = session('applicant_column', 'name');
        $direction = session('applicant_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Applicant::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new ApplicantExport($dataQuery),
            'applicant.xlsx');
    }

    public
    function print()
    {
        if (!Auth::user()->can('applicant export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Applicants.');
            if (Auth::user()->can('applicant index')) {
                return Redirect::route('applicant.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('applicant_keyword', '');
        $column = session('applicant_column', 'name');
        $direction = session('applicant_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'name',
            'dob',
        ];
        $dataQuery = Applicant::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('applicant.print', compact('data'));

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));

        return $pdf->stream('applicant-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
