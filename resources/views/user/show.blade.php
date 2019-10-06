@extends('layouts.master')
@php $nav_path = ['admin', 'user']; @endphp
@section('page-title')
View {{$user->name}}
@endsection
@section('page-header-title')
View {{$user->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$user->name}}</li>
</ol>
@endsection
@section('content')

    <user-show :record='@json($user)'></user-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/user/{{ $user->id }}/edit" class="btn btn-primary">Edit User</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/user/{{ $user->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete User">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/user') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
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
