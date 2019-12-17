@extends('layouts.master')
@php $nav_path = ['[[route_path]]']; @endphp
@section('page-title')
View {{$[[model_singular]]->name}}
@endsection
@section('page-header-title')
View {{$[[model_singular]]->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('[[view_folder]].index') }}">[[display_name_plural]]</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$[[model_singular]]->name}}</li>
</ol>
@endsection
@section('content')

    <[[route_path]]-show :record='@json($[[model_singular]])'></[[route_path]]-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/[[route_path]]/{{ $[[model_singular]]->id }}/edit" class="btn btn-primary">Edit [[display_name_singular]]</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/[[route_path]]/{{ $[[model_singular]]->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete [[display_name_singular]]">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/[[route_path]]') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this [[display_name_singular]]?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
