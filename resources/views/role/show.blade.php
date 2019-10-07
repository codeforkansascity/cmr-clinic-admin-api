@extends('layouts.master')
@php $nav_path = ['role']; @endphp
@section('page-title')
View {{$role->name}}
@stop
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Organizations</a></li>
    <li class="breadcrumb-item active" aria-current="location">{{$role->name}}</li>
</ol>
@stop
@section('page-header-title')
View Roles
@stop


@section('content')

<div class="row mb-4">
    <div class="col-md-5">

             @component('../components/std-show-field', ['value' => $role->name])
        Name        @endcomponent
             @component('../components/std-show-field', ['value' => $role->alias])
        Alias        @endcomponent
             @component('../components/std-show-field', ['value' => $role->on_master_roster])
        On Master Roster        @endcomponent


        <div class="row">
            <div class="col-md-6">
                <a href="/role/{{ $role->id }}/edit">
                    <button type="submit" class="btn btn-primary btn-sm">
                        Edit Role
                    </button>
                </a>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ url('/role') }}" class="btn btn-sm btn-default float-right">Return to List</a>
            </div>
        </div>

    </div>
</div>


@endsection
