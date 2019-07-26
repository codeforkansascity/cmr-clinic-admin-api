@extends('layouts.master')
@php $nav_path = ['status']; @endphp
@section('page-title')
    Edit {{$status->name}}
@endsection
@section('page-header-title')
    Edit {{$status->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('status.index') }}">Statuses</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$status->name}}</li>
    </ol>
@endsection
@section('content')
    <status-form csrf_token="{{ csrf_token() }}" :record='@json($status)'></status-form>
@endsection
