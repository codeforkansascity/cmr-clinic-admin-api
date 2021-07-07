@extends('layouts.master')
@php $nav_path = ['law']; @endphp
@section('page-title')
    Add New Laws
@endsection
@section('page-header-title')
    Add New Laws
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('law.index') }}">Laws</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Laws</li>
    </ol>
@endsection
@section('content')
    <law-form csrf_token="{{ csrf_token() }}"></law-form>
@endsection
