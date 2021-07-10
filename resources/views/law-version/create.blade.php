@extends('layouts.master')
@php $nav_path = ['law-version']; @endphp
@section('page-title')
    Add New Law Versions
@endsection
@section('page-header-title')
    Add New Law Versions
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('law-version.index') }}">Law Versions</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Law Versions</li>
    </ol>
@endsection
@section('content')
    <law-version-form :record='@json($law_version)' csrf_token="{{ csrf_token() }}"></law-version-form>
@endsection
