@extends('layouts.master')
@php $nav_path = ['comment']; @endphp
@section('page-title')
    Add New Comments
@endsection
@section('page-header-title')
    Add New Comments
@endsection
@section('page-help-link', '#TODO')
@section('page-header-breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('comment.index') }}">Comments</a></li>
        <li class="breadcrumb-item active" aria-current="location">Add New Comments</li>
    </ol>
@endsection
@section('content')
    <comment-form csrf_token="{{ csrf_token() }}"></comment-form>
@endsection
