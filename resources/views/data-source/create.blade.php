@extends('layouts.master')
@php $nav_path = ['data-source']; @endphp
@section('page-title')
    Add New Sources
@endsection
@section('page-header-title')
    Add New Sources
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('data-source.index') }}">Sources</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Sources</li>
    </ol>
@endsection
@section('content')
    <data-source-form csrf_token="{{ csrf_token() }}"></data-source-form>
@endsection
