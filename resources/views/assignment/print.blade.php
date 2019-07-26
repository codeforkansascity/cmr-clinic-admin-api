@extends('layouts.print')
@section('page-title', 'Assignments')
@section('table-headings-row')
    <tr>
            <th>Name</th>
            <th>Client Id</th>
            <th>User Id</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->client_id }}</td>
                    <td>{{ $obj->user_id }}</td>
                </tr>
    @endforeach
@endsection
