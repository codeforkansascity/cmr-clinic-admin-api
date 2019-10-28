@extends('layouts.print')
@section('page-title', 'Steps')
@section('table-headings-row')
    <tr>
            <th>Name</th>
            <th>Applicant Id</th>
            <th>Status Id</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->applicant_id }}</td>
                    <td>{{ $obj->status_id }}</td>
                </tr>
    @endforeach
@endsection
