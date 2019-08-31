@extends('layouts.master')
@php $nav_path = ['comment']; @endphp
@section('page-title')
View {{$comment->name}}
@endsection
@section('page-header-title')
View {{$comment->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('comment.index') }}">Comments</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$comment->name}}</li>
</ol>
@endsection
@section('content')

    <comment-show :record='@json($comment)'></comment-show>

    <div class="row">
        <div class="col-md-6">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/comment/{{ $comment->id }}/edit" class="btn btn-primary">Edit</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/comment/{{ $comment->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/comment') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Comments?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
