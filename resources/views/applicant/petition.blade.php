@extends('layouts.master')
@php $nav_path = ['applicant']; @endphp
@section('page-title')
Petition {{$applicant->name}}
@endsection
@section('page-header-title')
Petition {{$applicant->name}}
@endsection
@section('page-header-title-action')
    <a class="btn btn-secondary" href="{{ route('applicant.show', $applicant->id) }}">View</a>
    <a class="btn btn-secondary" href="{{ route('applicant.edit', $applicant->id) }}">Edit</a>
    <a class="btn btn-secondary" href="{{ route('applicant.preview', $applicant->id) }}">Preview</a>

@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('applicant.index') }}">Applicants</a></li>
    <li class="breadcrumb-item active" aria-current="location">Petition {{$applicant->name}}</li>
</ol>
@endsection
@section('content')

    <petition :data='@json($applicant)' :expungebles='@json($expungebles)' :service-list='@json($service_list)'></petition>

    <div class="row">
        <div class="col-md-6">

                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/applicant') }}" class="btn btn-default">Return to List</a>
                </div>

        </div>
    </div>

@endsection

