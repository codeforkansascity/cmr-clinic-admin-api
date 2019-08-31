@extends('layouts.master')
@php $nav_path = ['comment']; @endphp
@section('page-title')
    Edit {{$comment->name}}
@endsection
@section('page-header-title')
    Edit {{$comment->name}}
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('comment.index') }}">Comments</a></li>
        <li class="breadcrumb-item active" aria-current="location">Edit {{$comment->name}}</li>
    </ol>
@endsection
@section('content')
    <comment-form csrf_token="{{ csrf_token() }}" :record='@json($comment)'></comment-form>
@endsection
