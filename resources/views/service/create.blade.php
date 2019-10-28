@extends('layouts.master')
@php $nav_path = ['service']; @endphp
@section('page-title')
    Add New Services
@endsection
@section('page-header-title')
    Add New Services
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Services</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Services</li>
    </ol>
@endsection
@section('content')
    <service-form csrf_token="{{ csrf_token() }}"></service-form>
@endsection
