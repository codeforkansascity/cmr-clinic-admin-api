@extends('layouts.master')
@php $nav_path = ['jurisdiction-type']; @endphp
@section('page-title')
    Edit {{$jurisdiction_type->name}}
@endsection
@section('page-header-title')
    Edit {{$jurisdiction_type->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jurisdiction-type.index') }}">Jurisdiction Types</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$jurisdiction_type->name}}</li>
    </ol>
@endsection
@section('content')
    <jurisdiction-type-form csrf_token="{{ csrf_token() }}"
                            :record='@json($jurisdiction_type)'></jurisdiction-type-form>
@endsection
