@extends('layouts.master')
@php $nav_path = ['admin', 'invite']; @endphp
@section('page-title')
    View {{$invite->name}}
@endsection
@section('page-header-title')
    View {{$invite->name}}
@endsection
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('invite.index') }}">User Invitations</a></li>
        <li class="breadcrumb-item active" aria-current="location">View {{$invite->name}}</li>
    </ol>
@endsection
@section('content')
    <fieldset class="mb-4">
        <legend>General Information</legend>
        <div class="row">
            <div class="col-md-5">

                @component('../components/std-show-field', ['value' => $invite->email])
                    Email
                @endcomponent
                @component('../components/std-show-field', ['value' => $invite->name])
                    Name
                @endcomponent
                @component('../components/std-show-field', ['value' => $invite->role])
                    Role
                @endcomponent
            </div>
        </div>
    </fieldset>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/invite/{{ $invite->id }}/edit" class="btn btn-primary">Edit User Invitation</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST"
                              action="{{ url('/invite/'. $invite->id) }}">

                            <input type="hidden" name="_method" value="delete">

                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();"
                                   type="submit" value="Delete User Invitation">

                        </form>

                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/invitre') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function ConfirmDelete()
        {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }
    </script>
@endsection
