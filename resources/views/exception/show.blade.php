@extends('layouts.master')
@php $nav_path = ['exception']; @endphp
@section('page-title')
View {{$exception->name}}
@endsection
@section('page-header-title')
View {{$exception->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('exception.index') }}">Exceptions</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$exception->name}}</li>
</ol>
@endsection
@section('content')

    <exception-show :record='@json($exception)'></exception-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/exception/{{ $exception->id }}/edit" class="btn btn-primary">Edit Exceptions</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/exception/{{ $exception->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete Exceptions">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/exception') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-4">Statutes related to</h2>

    <dsp-exception-statutes :statutes='@json($statutes)'></dsp-exception-statutes>


@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Exceptions?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
