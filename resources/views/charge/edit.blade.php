@extends('layouts.master')
@php $nav_path = ['charge']; @endphp
@section('page-title')
    Edit {{$charge->name}}
@endsection
@section('page-header-title')
    Edit {{$charge->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('charge.index') }}">Charges</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$charge->name}}</li>
    </ol>
@endsection
@section('content')
    <charge-form csrf_token="{{ csrf_token() }}" :record='@json($charge)'></charge-form>
@endsection
