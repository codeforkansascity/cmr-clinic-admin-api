@extends('layouts.master')
@php $nav_path = ['client']; @endphp
@section('page-title')
Edit {{$client->name}}
@stop
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Applicants</a></li>
    <li class="breadcrumb-item active" aria-current="location">{{$client->name}}</li>
</ol>
@stop
@section('page-header-title')
Edit Applicants
@stop


@section('content')
<client-form csrf_token="{{ csrf_token() }}" :record='{!! json_encode($client,JSON_HEX_APOS) !!}'></client-form>

@endsection
