@extends('layouts.master')
@php $nav_path = ['jurisdiction']; @endphp
@section('page-title')
    Add New Jurisdiction
@endsection
@section('page-header-title')
    Add New Jurisdiction
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jurisdiction.index') }}">Jurisdictions</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Jurisdiction</li>
    </ol>
@endsection
@section('content')
    <jurisdiction-form csrf_token="{{ csrf_token() }}"></jurisdiction-form>
@endsection
