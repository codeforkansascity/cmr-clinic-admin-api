@extends('layouts.master')
@php $nav_path = ['exception']; @endphp
@section('page-title')
    Add New Exceptions
@endsection
@section('page-header-title')
    Add New Exceptions
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('exception.index') }}">Exceptions</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Exceptions</li>
    </ol>
@endsection
@section('content')
    <exception-form csrf_token="{{ csrf_token() }}"></exception-form>
@endsection
