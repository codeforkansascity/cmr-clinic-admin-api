@extends('layouts.master')
@php $nav_path = ['admin', 'user']; @endphp
@section('page-title')
    Add New User
@endsection
@section('page-header-title')
    Add New User
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New User</li>
    </ol>
@endsection
@section('content')
    <user-form csrf_token="{{ csrf_token() }}"></user-form>
@endsection
