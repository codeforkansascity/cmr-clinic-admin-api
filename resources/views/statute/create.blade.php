@extends('layouts.master')
@php $nav_path = ['statute']; @endphp
@section('page-title')
    Add New Statutes
@endsection
@section('page-header-title')
    Add New Statutes
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('statute.index') }}">Statutes</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Statutes</li>
    </ol>
@endsection
@section('content')
    <statute-form csrf_token="{{ csrf_token() }}"></statute-form>
@endsection
