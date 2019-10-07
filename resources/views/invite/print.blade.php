@extends('layouts.print')
@section('page-title', 'User Invitations')
@section('table-headings-row')
    <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Expires At</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)

        <tr>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->email }}</td>
                    <td>{{ $obj->expires_at }}</td>
                </tr>
    @endforeach
@endsection
