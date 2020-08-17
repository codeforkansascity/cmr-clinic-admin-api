@extends('layouts.master')
@php $nav_path = ['applicant']; @endphp
@section('page-title')
View {{$applicant->name}}
@endsection
@section('page-header-title')
View {{$applicant->name}}
@endsection
@section('page-header-title-action')
    <a class="btn btn-secondary" href="{{ route('applicant.show', $applicant->id) }}">View</a>
    <a class="btn btn-secondary" href="{{ route('applicant.edit', $applicant->id) }}">Edit</a>
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('applicant.index') }}">Applicants</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$applicant->name}}</li>
</ol>
@endsection
@section('content')

    <preview :data='@json($applicant)' :expungebles='@json($expungebles)'></preview>

    <div class="row">
        <div class="col-md-6">

                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/applicant') }}" class="btn btn-default">Return to List</a>
                </div>

        </div>
    </div>

@endsection

