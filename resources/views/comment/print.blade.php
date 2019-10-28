@extends('layouts.print')
@section('page-title', 'Comments')
@section('table-headings-row')
    <tr>
            <th>User Id</th>
            <th>Body</th>
            <th>Commentable Type</th>
            <th>Commentable Id</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->user_id }}</td>
                    <td>{{ $obj->body }}</td>
                    <td>{{ $obj->commentable_type }}</td>
                    <td>{{ $obj->commentable_id }}</td>
                </tr>
    @endforeach
@endsection
