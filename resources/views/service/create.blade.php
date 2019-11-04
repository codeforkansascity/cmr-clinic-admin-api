@extends('layouts.master')
@php $nav_path = ['service']; @endphp
@section('page-title')
    Add New Service
@endsection
@section('page-header-title')
    Add New Service
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Service</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Service</li>
    </ol>
@endsection
@section('content')
    <service-form csrf_token="{{ csrf_token() }}"></service-form>
@endsection
