@extends('layouts.master')
@php $nav_path = ['petition-field']; @endphp
@section('page-title')
View {{$petition_field->name}}
@endsection
@section('page-header-title')
View {{$petition_field->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('petition-field.index') }}">Petition Fields</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$petition_field->name}}</li>
</ol>
@endsection
@section('content')

    <petition-field-show :record='@json($petition_field)'></petition-field-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/petition-field/{{ $petition_field->id }}/edit" class="btn btn-primary">Edit Petition Fields</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/petition-field/{{ $petition_field->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete Petition Fields">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/petition-field') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Petition Fields?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
