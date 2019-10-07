@extends('layouts.master')
@php $nav_path = ['admin', 'invite']; @endphp
@section('page-title')
    Edit {{$invite->name}}
@endsection
@section('page-header-title')
    Edit {{$invite->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('invite.index') }}">User Invitations</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$invite->name}}</li>
    </ol>
@endsection
@section('content')
    <form action="{{ url('/invite/' . $invite->id ) }}" method="POST" class="form-horizontal">

        <form class="form" role="form" method="POST" action="{{ url('/invite/' . $invite->id) }}">

            {{ csrf_field() }}

            <input type="hidden" name="_method" value="PATCH">

            <div class="row">
                <div class="col-md-9">
                    @component('../components/std-form-group', ['fld' => 'email', 'label' => 'Email'])
                        <input type="text" class="form-control" name="email"
                               value="{{ old('email',$invite->email) }}" autocomplete="off">
                    @endcomponent
                </div>
            </div>


            <div class="row">
                <div class="col-md-9">
                    @component('../components/std-form-group', ['fld' => 'name', 'label' => 'Name'])
                        <input type="text" class="form-control" name="name"
                               value="{{ old('name',$invite->name) }}" autocomplete="off">
                    @endcomponent
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    @component('../components/std-form-group', ['fld' => 'role', 'label' => 'Role'])
                        @include('helpers.select-pick-one',
                             [
                                 'fld' => 'role',
                                 'selected_id' => $invite->role,
                                 'first_option' => 'Select a Role',
                                 'options' => $role_options
                             ])
                    @endcomponent
                </div>
            </div>

            <div class="form-group">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                            Change User Invitation
                        </button>
                    </div>
                    <div class="col-md-6 text-md-right mt-2 mt-md-0">
                        <a href="{{ url('/invite') }}" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
@endsection
