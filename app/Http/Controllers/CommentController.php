<?php

namespace App\Http\Controllers;



use App\Http\Middleware\TrimStrings;
use App\Comment;
use Illuminate\Http\Request;

use App\Http\Requests\CommentFormRequest;
use App\Http\Requests\CommentIndexRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Exports\CommentExport;
use Maatwebsite\Excel\Facades\Excel;
//use PDF; // TCPDF, not currently in use

class CommentController extends Controller
{

    /**
     * Examples
     *
     * Vue component example.
     *
        <ui-select-pick-one
            url="/api-comment/options"
            v-model="commentSelected"
            :selected_id=commentSelected"
            name="comment">
        </ui-select-pick-one>
     *
     *
     * Blade component example.
     *
     *   In Controler
     *
             $comment_options = \App\Comment::getOptions();


     *
     *   In View

            @component('../components/select-pick-one', [
                'fld' => 'comment_id',
                'selected_id' => $RECORD->comment_id,
                'first_option' => 'Select a Comments',
                'options' => $comment_options
            ])
            @endcomponent
     *
     * Permissions
     *

             Permission::create(['name' => 'comment index']);
             Permission::create(['name' => 'comment add']);
             Permission::create(['name' => 'comment update']);
             Permission::create(['name' => 'comment view']);
             Permission::create(['name' => 'comment destroy']);
             Permission::create(['name' => 'comment export-pdf']);
             Permission::create(['name' => 'comment export-excel']);

    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentIndexRequest $request)
    {

        if (!Auth::user()->can('comment index')) {
            \Session::flash('flash_error_message', 'You do not have access to Commentss.');
            return Redirect::route('home');
        }

        // Remember the search parameters, we saved them in the Query
        $page = session('comment_page', '');
        $search = session('comment_keyword', '');
        $column = session('comment_column', 'Name');
        $direction = session('comment_direction', '-1');

        $can_add = Auth::user()->can('comment add');
        $can_show = Auth::user()->can('comment view');
        $can_edit = Auth::user()->can('comment edit');
        $can_delete = Auth::user()->can('comment delete');
        $can_excel = Auth::user()->can('comment excel');
        $can_pdf = Auth::user()->can('comment pdf');

        return view('comment.index', compact('page', 'column', 'direction', 'search', 'can_add', 'can_edit', 'can_delete', 'can_show', 'can_excel', 'can_pdf'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
	{

        if (!Auth::user()->can('comment add')) {  // TODO: add -> create
            \Session::flash('flash_error_message', 'You do not have access to add a Comments.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('comment.index');
            } else {
                return Redirect::route('home');
            }
        }

	    return view('comment.create');
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentFormRequest $request)
    {

        $comment = new \App\Comment;

        try {
            $comment->add($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to process request'
            ], 400);
        }

        \Session::flash('flash_success_message', 'Vc Vendor ' . $comment->name . ' was added');

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

        if (!Auth::user()->can('comment view')) {
            \Session::flash('flash_error_message', 'You do not have access to view a Comments.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('comment.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($comment = $this->sanitizeAndFind($id)) {
            $can_edit = Auth::user()->can('comment edit');
            $can_delete = Auth::user()->can('comment delete');
            return view('comment.show', compact('comment','can_edit', 'can_delete'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Comments to display.');
            return Redirect::route('comment.index');
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
        if (!Auth::user()->can('comment edit')) {
            \Session::flash('flash_error_message', 'You do not have access to edit a Comments.');
            if (Auth::user()->can('vc_vendor index')) {
                return Redirect::route('comment.index');
            } else {
                return Redirect::route('home');
            }
        }

        if ($comment = $this->sanitizeAndFind($id)) {
            return view('comment.edit', compact('comment'));
        } else {
            \Session::flash('flash_error_message', 'Unable to find Comments to edit.');
            return Redirect::route('comment.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Comment $comment     * @return \Illuminate\Http\Response
     */
    public function update(CommentFormRequest $request, $id)
    {

//        if (!Auth::user()->can('comment update')) {
//            \Session::flash('flash_error_message', 'You do not have access to update a Comments.');
//            if (!Auth::user()->can('comment index')) {
//                return Redirect::route('comment.index');
//            } else {
//                return Redirect::route('home');
//            }
//        }

        if (!$comment = $this->sanitizeAndFind($id)) {
       //     \Session::flash('flash_error_message', 'Unable to find Comments to edit');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $comment->fill($request->all());

        if ($comment->isDirty()) {

            try {
                $comment->save();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Comments ' . $comment->name . ' was changed');
        } else {
            \Session::flash('flash_info_message', 'No changes were made');
        }

        return response()->json([
            'message' => 'Changed record'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment $comment     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (!Auth::user()->can('comment delete')) {
            \Session::flash('flash_error_message', 'You do not have access to remove a Comments.');
            if (Auth::user()->can('comment index')) {
                 return Redirect::route('comment.index');
            } else {
                return Redirect::route('home');
            }
        }

        $comment = $this->sanitizeAndFind($id);

        if ( $comment  && $comment->canDelete()) {

            try {
                $comment->delete();
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Unable to process request.'
                ], 400);
            }

            \Session::flash('flash_success_message', 'Invitation for ' . $comment->name . ' was removed.');
        } else {
            \Session::flash('flash_error_message', 'Unable to find Invite to delete.');

        }

        if (Auth::user()->can('comment index')) {
             return Redirect::route('comment.index');
        } else {
            return Redirect::route('home');
        }


    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return Comment or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\Comment::find(intval($id));
    }


    public function download()
    {

        if (!Auth::user()->can('comment excel')) {
            \Session::flash('flash_error_message', 'You do not have access to download Comments.');
            if (Auth::user()->can('comment index')) {
                return Redirect::route('comment.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('comment_keyword', '');
        $column = session('comment_column', 'name');
        $direction = session('comment_direction', '-1');

        $column = $column ? $column : 'name';

        // #TODO wrap in a try/catch and display english message on failuer.

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        $dataQuery = Comment::exportDataQuery($column, $direction, $search);
        //dump($data->toArray());
        //if ($data->count() > 0) {

        // TODO: is it possible to do 0 check before query executes somehow? i think the query would have to be executed twice, once for count, once for excel library
        return Excel::download(
            new CommentExport($dataQuery),
            'comment.xlsx');

    }


        public function print()
{
        if (!Auth::user()->can('comment export-pdf')) { // TODO: i think these permissions may need to be updated to match initial permissions?
            \Session::flash('flash_error_message', 'You do not have access to print Comments');
            if (Auth::user()->can('comment index')) {
                return Redirect::route('comment.index');
            } else {
                return Redirect::route('home');
            }
        }

        // Remember the search parameters, we saved them in the Query
        $search = session('comment_keyword', '');
        $column = session('comment_column', 'name');
        $direction = session('comment_direction', '-1');
        $column = $column ? $column : 'name';

        info(__METHOD__ . ' line: ' . __LINE__ . " $column, $direction, $search");

        // Get query data
        $columns = [
            'user_id',
            'body',
            'commentable_type',
            'commentable_id',
        ];
        $dataQuery = Comment::pdfDataQuery($column, $direction, $search, $columns);
        $data = $dataQuery->get();

        // Pass it to the view for html formatting:
        $printHtml = view('comment.print', compact( 'data' ) );

        // Begin DOMPDF/laravel-dompdf
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions(['isPhpEnabled' => TRUE]);
        $pdf->loadHTML($printHtml);
        $currentDate = new \DateTime(null, new \DateTimeZone('America/Chicago'));
        return $pdf->stream('comment-' . $currentDate->format('Ymd_Hi') . '.pdf');

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
