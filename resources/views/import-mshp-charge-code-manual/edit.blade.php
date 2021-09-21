@extends('layouts.master')
@php $nav_path = ['import-mshp-charge-code-manual']; @endphp
@section('page-title')
    Edit {{$import_mshp_charge_code_manual->name}}
@endsection
@section('page-header-title')
    Edit {{$import_mshp_charge_code_manual->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('import-mshp-charge-code-manual.index') }}">Charge Codes</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$import_mshp_charge_code_manual->name}}</li>
    </ol>
@endsection
@section('content')
    <import-mshp-charge-code-manual-form csrf_token="{{ csrf_token() }}" :record='@json($import_mshp_charge_code_manual)'></import-mshp-charge-code-manual-form>
@endsection
