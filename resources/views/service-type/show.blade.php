@extends('layouts.master')
@php $nav_path = ['service-type']; @endphp
@section('page-title')
View {{$service_type->name}}
@endsection
@section('page-header-title')
View {{$service_type->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('service-type.index') }}">Service Types</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$service_type->name}}</li>
</ol>
@endsection
@section('content')

    <service-type-show :record='@json($service_type)'></service-type-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/service-type/{{ $service_type->id }}/edit" class="btn btn-primary">Edit service_type</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/service-type/{{ $service_type->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete Service Type">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/service-type') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Service Types?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
