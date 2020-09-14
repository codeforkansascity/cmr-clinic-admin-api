@extends('layouts.master')
@php $nav_path = ['applicant']; @endphp
@section('page-title')
    Edit {{$applicant->name}}
@endsection
@section('page-header-title')
    Edit {{$applicant->name}}
@endsection
@section('page-header-title-action')
    <a class="btn btn-secondary" href="{{ route('applicant.show', $applicant->id) }}">View</a>
    <a class="btn btn-secondary disabled" href="{{ route('applicant.edit', $applicant->id) }}">Edit</a>
    <a class="btn btn-secondary" href="{{ route('applicant.preview', $applicant->id) }}">Review</a>
    <a class="btn btn-secondary" href="{{ route('applicant.petition', $applicant->id) }}">Petition</a>
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('applicant.index') }}">Applicants</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$applicant->name}}</li>
    </ol>
@endsection
@section('content')
    <applicant-container csrf_token="{{ csrf_token() }}"  :can-cms="{{ $can_cms }}" :data='@json($applicant)'></applicant-container>
@endsection
