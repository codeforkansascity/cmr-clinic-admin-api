<?php

namespace App\Http\Controllers;



use App\Conviction;
use App\Http\Requests\CaseServiceCreateRequest;
use App\Http\Requests\CaseServiceUpdateRequest;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;


class CaseServiceController extends Controller
{
    public function store(CaseServiceCreateRequest $request, Conviction $case)
    {

        $service = $request->service;
        $name = $request->name;


        if(!empty($service['id'])) {
            $service = Service::find($service['id']);
            $case->services()->attach($service, ['name' => $name]);
        } else {
            $service =  $case->services()->create($service, ['name' => $name]);
        }

        $service = $service->load('service_type');

        \Session::flash('flash_success_message', 'Vc Vendor ' . $service->name . ' was added');

        return response()->json($service, 200);

    }




    public function update(CaseServiceUpdateRequest $request, Conviction $case, Service $service)
    {

        $name = $request->name;

        $case->services()->updateExistingPivot($service->id, ['name' => $name]);


        return response()->json([
            'message' => 'Changed record'
        ], 200);
    }


    public function destroy(Request $request, Conviction $case, Service $service)
    {

        $case->services()->detach($service->id);

        return response()->json([
            'message' => 'Deleted record'
        ], 200);

    }


}
