@extends('layouts.master')
@php $nav_path = ['role-description']; @endphp
@section('page-title')
    Add New Role Descriptions
@endsection
@section('page-header-title')
    Add New Role Descriptions
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('role-description.index') }}">Role Descriptions</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Role Descriptions</li>
    </ol>
@endsection
@section('content')
    <role-description-form csrf_token="{{ csrf_token() }}"></role-description-form>
@endsection
