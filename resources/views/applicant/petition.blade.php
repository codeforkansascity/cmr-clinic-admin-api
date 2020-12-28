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
    <a class="btn btn-secondary" href="{{ route('applicant.preview', $applicant->id) }}">Review</a>
    <a class="btn btn-secondary disabled" href="{{ route('applicant.petition', $applicant->id) }}">Petition</a>

@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('applicant.index') }}">Applicants</a></li>
    <li class="breadcrumb-item active" aria-current="location">Petition {{$applicant->name}}</li>
</ol>
@endsection
@section('content')

    <petition :data='@json($applicant)' :expungebles='@json($expungebles)' :service-list='@json($service_list)'
    petition-count="{{$petition_count}}" group-count="{{$group_count}}" case-count="{{$case_count}}"></petition>

@endsection

