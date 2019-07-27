@extends('layouts.master')
@php $nav_path = ['conviction']; @endphp
@section('page-title')
    Edit {{$conviction->name}}
@endsection
@section('page-header-title')
    Edit {{$conviction->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('conviction.index') }}">Cases</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$conviction->name}}</li>
    </ol>
@endsection
@section('content')
    <case-form csrf_token="{{ csrf_token() }}" :record='@json($conviction)'></case-form>
@endsection
