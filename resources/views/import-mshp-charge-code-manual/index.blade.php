@extends('layouts.master')
@php $nav_path = ['import-mshp-charge-code-manual']; @endphp
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
    <div class="row mb-5">
        <div class="col-11">
            The following is from the
            <a href="https://www.mshp.dps.missouri.gov/MSHPWeb/PatrolDivisions/CRID/documents/August2021ChargeCodeManual.pdf">
                2020-2021 Missouri Charge Code Manual
            </a>
            found on the
            <a href="https://www.mshp.dps.missouri.gov/CJ08Client/Home/ChargeCode">
                Missouri State Highway Patrol Charge Code Manual page.
            </a>
        </div>
    </div>

    <import-mshp-charge-code-manual-grid :params="{
            Page: '{{ $page }}',
            Search: '{{ $search }}',
            sortOrder: '{{ $direction }}',
            sortKey: '{{ $column }}',
            CanAdd: '{{ $can_add }}',
            CanEdit: '{{ $can_edit }}',
            CanShow: '{{ $can_show }}',
            CanDelete: '{{ $can_delete }}',
            CanExcel: '{{ $can_excel }}'
        }"></import-mshp-charge-code-manual-grid>
@endsection
