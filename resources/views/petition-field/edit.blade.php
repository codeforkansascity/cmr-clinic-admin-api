@extends('layouts.master')
@php $nav_path = ['petition-field']; @endphp
@section('page-title')
    Edit {{$petition_field->name}}
@endsection
@section('page-header-title')
    Edit {{$petition_field->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('petition-field.index') }}">Petition Fields</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$petition_field->name}}</li>
    </ol>
@endsection
@section('content')
    <petition-field-form csrf_token="{{ csrf_token() }}" :record='@json($petition_field)'></petition-field-form>
@endsection
