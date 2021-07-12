@extends('layouts.master')
@php $nav_path = ['law']; @endphp
@section('page-title')
View {{$law->name}}
@endsection
@section('page-header-title')
View {{$law->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('law.index') }}">Laws</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$law->name}}</li>
</ol>
@endsection
@section('content')

    <law-show :record='@json($law)'  :charges='@json($charges)' :exceptions='@json($exceptions)' :versions='@json($versions)'></law-show>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/law-version/create/{{ $law->id }}" class="btn btn-primary">Suggest Changes</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">

                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/law') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h4>Changes Pending Review</h4>

            <law-changes-pending-review :versions='@json($versions)'></law-changes-pending-review>

        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h4>History of Changes</h4>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h4>Notice</h4>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <h4>Relevant Statutes</h4>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <h4>Versions</h4>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Laws?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
