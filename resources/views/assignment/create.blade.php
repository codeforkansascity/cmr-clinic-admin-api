@extends('layouts.master')
@php $nav_path = ['assignment']; @endphp
@section('page-title')
    Add New Assignment
@endsection
@section('page-header-title')
    Add New Assignment
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('assignment.index') }}">Assignments</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Assignment</li>
    </ol>
@endsection
@section('content')
    <assignment-form csrf_token="{{ csrf_token() }}"></assignment-form>
@endsection
