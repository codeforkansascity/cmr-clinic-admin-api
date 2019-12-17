@extends('layouts.master')
@php $nav_path = ['[[route_path]]']; @endphp
@section('page-title', '[[display_name_plural]]')
@section('page-header-title', '[[display_name_plural]]')
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="location">[[display_name_plural]]</li>
    </ol>
@endsection
@section('content')
    <[[view_folder]]-grid :params="{
            Page: '{{ $page }}',
            Search: '{{ $search }}',
            sortOrder: '{{ $direction }}',
            sortKey: '{{ $column }}',
            CanAdd: '{{ $can_add }}',
            CanEdit: '{{ $can_edit }}',
            CanShow: '{{ $can_show }}',
            CanDelete: '{{ $can_delete }}',
            CanExcel: '{{ $can_excel }}'
        }"></[[view_folder]]-grid>
@endsection
