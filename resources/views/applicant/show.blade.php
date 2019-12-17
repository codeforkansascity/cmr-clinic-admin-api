@extends('layouts.master')
@php $nav_path = ['applicant']; @endphp
@section('page-title')
View {{$applicant->name}}
@endsection
@section('page-header-title')
View {{$applicant->name}}
@endsection
@section('page-header-title-action')
    <a class="btn btn-secondary" href="{{ route('applicant.edit', $applicant->id) }}">Edit</a>
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('applicant.index') }}">Applicants</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$applicant->name}}</li>
</ol>
@endsection
@section('content')

    <applicant-show :data='@json($applicant)'></applicant-show>

    <div class="row">
        <div class="col-md-6">

                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/applicant') }}" class="btn btn-default">Return to List</a>
                </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Applicants?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
