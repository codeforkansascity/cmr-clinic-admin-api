@extends('layouts.master')
@php $nav_path = ['[[route_path]]']; @endphp
@section('page-title')
    Edit {{$[[model_singular]]->name}}
@endsection
@section('page-header-title')
    Edit {{$[[model_singular]]->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('[[view_folder]].index') }}">[[display_name_plural]]</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$[[model_singular]]->name}}</li>
    </ol>
@endsection
@section('content')
    <[[view_folder]]-form csrf_token="{{ csrf_token() }}" :record='@json($[[model_singular]])'></[[view_folder]]-form>
@endsection
