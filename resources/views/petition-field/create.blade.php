@extends('layouts.master')
@php $nav_path = ['petition-field']; @endphp
@section('page-title')
    Add New Petition Fields
@endsection
@section('page-header-title')
    Add New Petition Fields
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('petition-field.index') }}">Petition Fields</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Petition Fields</li>
    </ol>
@endsection
@section('content')
    <petition-field-form csrf_token="{{ csrf_token() }}"></petition-field-form>
@endsection
