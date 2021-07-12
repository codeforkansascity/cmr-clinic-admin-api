@extends('layouts.master')
@php $nav_path = ['law-version']; @endphp
@section('page-title')
View {{$law_version->name}}
@endsection
@section('page-header-title')
View {{$law_version->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('law-version.index') }}">Law Versions</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$law_version->name}}</li>
</ol>
@endsection
@section('content')

    <law-version-show :record='@json($law_version)' :exceptions='@json($exceptions)'></law-version-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/law-version/{{ $law_version->id }}/edit" class="btn btn-primary">Edit Law Versions</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_edit)
                        <a href="/law-version/{{ $law_version->id }}/approve" class="btn btn-primary">Approve</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/law-version') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Law Versions?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
