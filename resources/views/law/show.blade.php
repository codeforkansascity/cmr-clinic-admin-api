@extends('layouts.master')
@php $nav_path = ['law']; @endphp
@section('page-title')
View {{$law->name}}
@endsection
@section('page-header-title')
View {{$law->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('law.index') }}">Laws</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$law->name}}</li>
</ol>
@endsection
@section('content')

    <law-show :record='@json($law)'  :charges='@json($charges)' :exceptions='@json($exceptions)'></law-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/law-version/create/{{ $law->id }}" class="btn btn-primary">Edit Laws</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/law/{{ $law->id }}">
                            @method('delete')
                            @csrf

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete Laws">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/law') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Laws?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
