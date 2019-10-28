@extends('layouts.print')
@section('page-title', 'Applicants')
@section('table-headings-row')
    <tr>
            <th>Name</th>
            <th>Notes</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->notes }}</td>
                </tr>
    @endforeach
@endsection
