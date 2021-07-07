@extends('layouts.master
@php $nav_path = ['law-version']; @endphp
@section('page-title')
    Edit {{$law_version->name}}
@endsection
@section('page-header-title')
    Edit {{$law_version->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('law-version.index') }}">Law Versions</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$law_version->name}}</li>
    </ol>
@endsection
@section('content')
    <law-version-form csrf_token="{{ csrf_token() }}" :record='@json($law_version)'></law-version-form>
@endsection
