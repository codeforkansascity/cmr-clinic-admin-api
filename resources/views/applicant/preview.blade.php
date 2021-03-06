@extends('layouts.master')
@php $nav_path = ['applicant']; @endphp
@section('page-title')
Review {{$applicant->name}}
@endsection
@section('page-header-title')
    Review {{$applicant->name}}
@endsection
@section('page-header-title-action')
    <a class="btn btn-secondary" href="{{ route('applicant.show', $applicant->id) }}">View</a>
    <a class="btn btn-secondary" href="{{ route('applicant.edit', $applicant->id) }}">Edit</a>
    <a class="btn btn-secondary disabled" href="{{ route('applicant.preview', $applicant->id) }}">Review</a>
    <a class="btn btn-secondary" href="{{ route('applicant.petition', $applicant->id) }}">Petition</a>
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('applicant.index') }}">Applicants</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$applicant->name}}</li>
</ol>
@endsection
@section('content')

    <preview :data='@json($applicant)' :expungebles='@json($expungebles)' :not-selected-to-expunge='@json($not_selected_to_expunge)' :service-list='@json($service_list)'></preview>

    <div class="row">
        <div class="col-md-6">

                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/applicant') }}" class="btn btn-default">Return to List</a>
                </div>

        </div>
    </div>

@endsection

