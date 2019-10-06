@extends('layouts.master')
@php $nav_path = ['service-type']; @endphp
@section('page-title')
    Add New Service Types
@endsection
@section('page-header-title')
    Add New Service Types
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('service-type.index') }}">Service Types</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Service Types</li>
    </ol>
@endsection
@section('content')
    <service-type-form csrf_token="{{ csrf_token() }}"></service-type-form>
@endsection
