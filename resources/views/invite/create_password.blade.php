@extends('layouts.master')
@php $nav_path = ['admin', 'invite']; @endphp
@section('page-title')
    Accept Invitation {{$invite->name}}
@endsection
@section('page-header-title')
    Accept Invitation {{$invite->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="location">Accept Invitation {{$invite->name}}</li>
    </ol>
@endsection
@section('content')
    <create-password-form csrf_token="{{ csrf_token() }}"
          :record='{!! json_encode($invite,JSON_HEX_APOS) !!}'
          :password_user_inputs='{!! json_encode($user_inputs,JSON_HEX_APOS) !!}'></create-password-form>
@endsection
