@extends('layouts.master')
@php $nav_path = ['admin', 'invite']; @endphp
@section('page-title', 'Add New Invitation')
@section('page-header-title', 'Add New Invitation')
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('invite.index') }}">User Invitations</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New User Invitation</li>
    </ol>
@endsection
@section('content')
    <form action="{{ url('/invite'.( isset($model) ? "/" . $model->id : "")) }}" method="POST" class="form-horizontal">

        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-9">
                @component('../components/std-form-group', ['fld' => 'email', 'label' => 'Email'])
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" autocomplete="off">
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                @component('../components/std-form-group', ['fld' => 'name', 'label' => 'Name'])
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="off">
                @endcomponent
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                @component('../components/std-form-group', ['fld' => 'role', 'label' => 'Role'])
                    @include('helpers.select-pick-one',
                         [
                             'fld' => 'role',
                             'selected_id' => '0',
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
                        Send Invite
                    </button>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0 ">
                    <a href="{{ url('/invite') }}" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
@endsection
