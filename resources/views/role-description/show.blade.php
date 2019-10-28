@extends('layouts.master')
@php $nav_path = ['role-description']; @endphp
@section('page-title')
View {{$role_description->name}}
@endsection
@section('page-header-title')
View {{$role_description->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('role-description.index') }}">Role Descriptions</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$role_description->name}}</li>
</ol>
@endsection
@section('content')

    <role-description-show :record='@json($role_description)'></role-description-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/role-description/{{ $role_description->id }}/edit" class="btn btn-primary">Edit Role Description</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/role-description/{{ $role_description->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete Role Description">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/role-description') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Role Descriptions?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
