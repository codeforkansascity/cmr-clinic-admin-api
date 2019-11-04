@extends('layouts.master')
@php $nav_path = ['service']; @endphp
@section('page-title')
    Edit {{$service->name}}
@endsection
@section('page-header-title')
    Edit {{$service->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Service</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$service->name}}</li>
    </ol>
@endsection
@section('content')
    <service-form csrf_token="{{ csrf_token() }}" :record='@json($service)'></service-form>
@endsection
