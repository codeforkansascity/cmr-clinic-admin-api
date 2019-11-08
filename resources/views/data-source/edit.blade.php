@extends('layouts.master')
@php $nav_path = ['data-source']; @endphp
@section('page-title')
    Edit {{$data_source->name}}
@endsection
@section('page-header-title')
    Edit {{$data_source->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('data-source.index') }}">Sources</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$data_source->name}}</li>
    </ol>
@endsection
@section('content')
    <data-source-form csrf_token="{{ csrf_token() }}" :record='@json($data_source)'></data-source-form>
@endsection
