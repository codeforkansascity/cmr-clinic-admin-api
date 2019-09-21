@extends('layouts.master')
@php $nav_path = ['service-type']; @endphp
@section('page-title')
    Edit {{$service_type->name}}
@endsection
@section('page-header-title')
    Edit {{$service_type->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('service-type.index') }}">Service Types</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$service_type->name}}</li>
    </ol>
@endsection
@section('content')
    <service-type-form csrf_token="{{ csrf_token() }}" :record='@json($service_type)'></service-type-form>
@endsection
