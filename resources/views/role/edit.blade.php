@extends('layouts.master')
@php $nav_path = ['role']; @endphp
@section('page-title')
Edit {{$role->name}}
@stop
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
    <li class="breadcrumb-item active" aria-current="location">{{$role->name}}</li>
</ol>
@stop
@section('page-header-title')
Edit Role
@stop


@section('content')

        <form action="{{ url('/role/' . $role->id ) }}" method="POST" class="form-horizontal">

<form class="form" role="form" method="POST" action="{{ url('/role/' . $role->id) }}">

{{ csrf_field() }}

                <input type="hidden" name="_method" value="PATCH">


                <div class="row">
                    <div class="col-md-9">
                        @component('../components/std-form-group', ['fld' => 'name', 'label' => 'Name'])
                        <input type="text" class="form-control" name="name"
                               value="{{ old('name',$role->name) }}">
                        @endcomponent
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-9">
                        @component('../components/std-form-group', ['fld' => 'alias', 'label' => 'Alias'])
                        <input type="text" class="form-control" name="alias"
                               value="{{ old('alias',$role->alias) }}">
                        @endcomponent
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-9">
                        @component('../components/std-form-group', ['fld' => 'on_master_roster', 'label' => 'On Master Roster'])
                        <input type="text" class="form-control" name="on_master_roster"
                               value="{{ old('on_master_roster',$role->on_master_roster) }}">
                        @endcomponent
                    </div>
                </div>


            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Change Role
                        </button>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ url('/role') }}" class="btn btn-sm btn-default float-right">Cancel</a>
                    </div>
                </div>
            </div>
        </form>


@endsection
