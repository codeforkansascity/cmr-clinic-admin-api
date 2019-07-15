@extends('layouts.master')
@php $nav_path = ['status']; @endphp
@section('page-title', 'Statuses')
@section('page-header-title', 'Statuses')
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="location">Statuses</li>
    </ol>
@endsection
@section('content')
    <status-grid :params="{
            Page: '{{ $page }}',
            Search: '{{ $search }}',
            sortOrder: '{{ $direction }}',
            sortKey: '{{ $column }}',
            CanAdd: '{{ $can_add }}',
            CanEdit: '{{ $can_edit }}',
            CanShow: '{{ $can_show }}',
            CanDelete: '{{ $can_delete }}',
            CanExcel: '{{ $can_excel }}'
        }"></status-grid>
@endsection
