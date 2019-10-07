@extends('layouts.master')
@php $nav_path = ['role-description']; @endphp
@section('page-title')
    Edit {{$role_description->name}}
@endsection
@section('page-header-title')
    Edit {{$role_description->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('role-description.index') }}">Role Descriptions</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$role_description->name}}</li>
    </ol>
@endsection
@section('content')
    <role-description-form csrf_token="{{ csrf_token() }}" :record='@json($role_description)'></role-description-form>
@endsection
