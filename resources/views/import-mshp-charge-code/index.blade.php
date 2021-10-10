@extends('layouts.master')
@php $nav_path = ['import-mshp-charge-code']; @endphp
@section('page-title', 'Charge Codes')
@section('page-header-title', 'Charge Codes')
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="location">Charge Codes</li>
    </ol>
@endsection
@section('content')
    <import-mshp-charge-code-grid :params="{
            Page: '{{ $page }}',
            Search: '{{ $search }}',
            sortOrder: '{{ $direction }}',
            sortKey: '{{ $column }}',
            CanAdd: '{{ $can_add }}',
            CanEdit: '{{ $can_edit }}',
            CanShow: '{{ $can_show }}',
            CanDelete: '{{ $can_delete }}',
            CanExcel: '{{ $can_excel }}'
        }"></import-mshp-charge-code-grid>
@endsection
