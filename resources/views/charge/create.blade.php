@extends('layouts.master')
@php $nav_path = ['charge']; @endphp
@section('page-title')
    Add New Charges
@endsection
@section('page-header-title')
    Add New Charges
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('charge.index') }}">Charges</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Charges</li>
    </ol>
@endsection
@section('content')
    <charge-form csrf_token="{{ csrf_token() }}"></charge-form>
@endsection
