@extends('layouts.master')
@php $nav_path = ['data-source']; @endphp
@section('page-title')
View {{$data_source->name}}
@endsection
@section('page-header-title')
View {{$data_source->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('data-source.index') }}">Sources</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$data_source->name}}</li>
</ol>
@endsection
@section('content')

    <data-source-show :record='@json($data_source)'></data-source-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/data-source/{{ $data_source->id }}/edit" class="btn btn-primary">Edit data_source</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/data-source/{{ $data_source->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete data_source">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/data-source') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Sources?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
