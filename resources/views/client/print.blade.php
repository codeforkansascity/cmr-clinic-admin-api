@extends('layouts.print')
@section('page-title', 'Applicants')
@section('table-headings-row')
    <tr>
            <th>Full Name</th>
            <th>Phone</th>
            <th>Filing Court</th>
            <th>Status</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->full_name }}</td>
                    <td>{{ $obj->phone }}</td>
                    <td>{{ $obj->filing_court }}</td>
                    <td>{{ $obj->status }}</td>
                </tr>
    @endforeach
@endsection
