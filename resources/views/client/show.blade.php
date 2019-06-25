@extends('layouts.master')
@php $nav_path = ['client']; @endphp
@section('page-title')
View {{$client->name}}
@stop
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Applicants</a></li>
    <li class="breadcrumb-item active" aria-current="location">{{$client->name}}</li>
</ol>

@stop
@section('page-header-title')
View Applicants
@stop

@section('content')

<div class="row mb-4">
    <div class="col-md-5">

             @component('../components/std-show-field', ['value' => $client->id])
        Id        @endcomponent
             @component('../components/std-show-field', ['value' => $client->full_name])
        Full Name        @endcomponent
             @component('../components/std-show-field', ['value' => $client->phone])
        Phone        @endcomponent
             @component('../components/std-show-field', ['value' => $client->email])
        Email        @endcomponent
             @component('../components/std-show-field', ['value' => $client->sex])
        Sex        @endcomponent
             @component('../components/std-show-field', ['value' => $client->race])
        Race        @endcomponent
             @component('../components/std-show-field', ['value' => $client->dob])
        Dob        @endcomponent
             @component('../components/std-show-field', ['value' => $client->address_line_1])
        Address Line 1        @endcomponent
             @component('../components/std-show-field', ['value' => $client->address_line_2])
        Address Line 2        @endcomponent
             @component('../components/std-show-field', ['value' => $client->city])
        City        @endcomponent
             @component('../components/std-show-field', ['value' => $client->state])
        State        @endcomponent
             @component('../components/std-show-field', ['value' => $client->zip_code])
        Zip Code        @endcomponent
             @component('../components/std-show-field', ['value' => $client->license_number])
        License Number        @endcomponent
             @component('../components/std-show-field', ['value' => $client->license_issuing_state])
        License Issuing State        @endcomponent
             @component('../components/std-show-field', ['value' => $client->license_expiration_date])
        License Expiration Date        @endcomponent
             @component('../components/std-show-field', ['value' => $client->filing_court])
        Filing Court        @endcomponent
             @component('../components/std-show-field', ['value' => $client->judicial_circuit_number])
        Judicial Circuit Number        @endcomponent
             @component('../components/std-show-field', ['value' => $client->judge_name])
        Judge Name        @endcomponent
             @component('../components/std-show-field', ['value' => $client->division_name])
        Division Name        @endcomponent
             @component('../components/std-show-field', ['value' => $client->petitioner_name])
        Petitioner Name        @endcomponent
             @component('../components/std-show-field', ['value' => $client->division_number])
        Division Number        @endcomponent
             @component('../components/std-show-field', ['value' => $client->city_name_here])
        City Name Here        @endcomponent
             @component('../components/std-show-field', ['value' => $client->county_name])
        County Name        @endcomponent
             @component('../components/std-show-field', ['value' => $client->arresting_county])
        Arresting County        @endcomponent
             @component('../components/std-show-field', ['value' => $client->prosecuting_county])
        Prosecuting County        @endcomponent
             @component('../components/std-show-field', ['value' => $client->arresting_municipality])
        Arresting Municipality        @endcomponent
             @component('../components/std-show-field', ['value' => $client->other_agencies_name])
        Other Agencies Name        @endcomponent
             @component('../components/std-show-field', ['value' => $client->previous_expungements])
        Previous Expungements        @endcomponent
             @component('../components/std-show-field', ['value' => $client->status])
        Status        @endcomponent
             @component('../components/std-show-field', ['value' => $client->external_ref])
        External Ref        @endcomponent
             @component('../components/std-show-field', ['value' => $client->any_pending_cases])
        Any Pending Cases        @endcomponent
     

        <div class="row">
            <div class="col-md-6">
                <a href="/client/{{ $client->id }}/edit">
                    <button type="submit" class="btn btn-primary btn-sm">
                        Edit
                    </button>
                </a>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ url('/client') }}" class="btn btn-sm btn-default float-right">Return to List</a>
            </div>
        </div>

    </div>
</div>

@endsection
