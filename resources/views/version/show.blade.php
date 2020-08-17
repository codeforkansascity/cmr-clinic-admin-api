@extends('layouts.master')
@php $nav_path = ['version']; @endphp
@section('page-title')
    Revision History
@endsection
@section('page-header-title')
Revision History
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item">Revision History</li>
</ol>
@endsection
@section('content')

<h2>3.1.8.0.1.demo</h2>
    <ol>
        <li>CDL Questions added, all existing applicants have been set to CDL Unknown</li>

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
