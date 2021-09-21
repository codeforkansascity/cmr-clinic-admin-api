@extends('layouts.master')
@php $nav_path = ['import-mshp-charge-code-manual']; @endphp
@section('page-title')
    Add New Charge Codes
@endsection
@section('page-header-title')
    Add New Charge Codes
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('import-mshp-charge-code-manual.index') }}">Charge Codes</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Charge Codes</li>
    </ol>
@endsection
@section('content')
    <import-mshp-charge-code-manual-form csrf_token="{{ csrf_token() }}"></import-mshp-charge-code-manual-form>
@endsection
