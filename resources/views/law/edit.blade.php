@extends('layouts.master
@php $nav_path = ['law']; @endphp
@section('page-title')
    Edit {{$law->name}}
@endsection
@section('page-header-title')
    Edit {{$law->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('law.index') }}">Laws</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$law->name}}</li>
    </ol>
@endsection
@section('content')
    <law-form csrf_token="{{ csrf_token() }}" :record='@json($law)'></law-form>
@endsection
