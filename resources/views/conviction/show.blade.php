@extends('layouts.master')
@php $nav_path = ['conviction']; @endphp
@section('page-title')
View {{$conviction->name}}
@endsection
@section('page-header-title')
View {{$conviction->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('conviction.index') }}">Cases</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$conviction->name}}</li>
</ol>
@endsection
@section('content')

    <case-show :record='@json($conviction)'></case-show>

    <div class="row">
        <div class="col-md-6">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/conviction/{{ $conviction->id }}/edit" class="btn btn-primary">Edit</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/conviction/{{ $conviction->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/conviction') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Case?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
