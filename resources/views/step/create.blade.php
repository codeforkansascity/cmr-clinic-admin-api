@extends('layouts.master')
@php $nav_path = ['step']; @endphp
@section('page-title')
    Add New Step
@endsection
@section('page-header-title')
    Add New Step
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('step.index') }}">Steps</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Step</li>
    </ol>
@endsection
@section('content')
    <step-form csrf_token="{{ csrf_token() }}"></step-form>
@endsection
