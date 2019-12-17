@extends('layouts.master')
@php $nav_path = ['jurisdiction']; @endphp
@section('page-title', 'Jurisdictions')
@section('page-header-title', 'Jurisdictions')
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="location">Jurisdictions</li>
    </ol>
@endsection
@section('content')
    <jurisdiction-grid :params="{
            Page: '{{ $page }}',
            Search: '{{ $search }}',
            sortOrder: '{{ $direction }}',
            sortKey: '{{ $column }}',
            CanAdd: '{{ $can_add }}',
            CanEdit: '{{ $can_edit }}',
            CanShow: '{{ $can_show }}',
            CanDelete: '{{ $can_delete }}',
            CanExcel: '{{ $can_excel }}'
        }"></jurisdiction-grid>
@endsection
