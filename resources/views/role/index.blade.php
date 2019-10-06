@extends('layouts.master')
@php $nav_path = ['role']; @endphp
@section('page-title', 'Roles')
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="location">Role</li>
</ol>
@stop
@section('page-header-title')
Roles
@stop



@section('content')


<role-grid :params="{
        Page: '{{ $page }}',
        Search: '{{ $search }}',
        sortOrder: '{{ $direction }}',
        sortKey: '{{ $column }}',
        CanAdd: '{{ $can_add }}',
        CanEdit: '{{ $can_edit }}',
        CanShow: '{{ $can_show }}',
        CanDelete: '{{ $can_delete }}',
        CanExcel: '{{ $can_excel }}'
    }"></role-grid>



@endsection