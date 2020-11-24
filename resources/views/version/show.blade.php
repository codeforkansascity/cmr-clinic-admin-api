@extends('layouts.master')
@php $nav_path = ['version']; @endphp
@section('page-title')
    About
@endsection
@section('page-header-title')
    About
@endsection
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">About</li>
    </ol>
@endsection
@section('content')

    <h2>Revision History</h2>
    <h3>August 20, 2020</h3>
    <ol>
        <li>Draft version of Petition for CLE Demo</li>
    </ol>


@endsection
@section('scripts')
    <script>
        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete this User?");
            if (x)
                return true;
            else
                return false;
        }
    </script>
@endsection
