@extends('layouts.master')
@php $nav_path = ['meta', 'change-password']; @endphp
@section('page-title', 'Change Password')
@section('page-header-title', 'Change Password')
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="location">Change Password</li>
    </ol>
@endsection
@section('content')
    <change-password-form csrf_token="{{ csrf_token() }}"
          :password_user_inputs='{!! json_encode($user_inputs,JSON_HEX_APOS) !!}'></change-password-form>
@endsection
