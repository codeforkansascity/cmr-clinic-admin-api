@extends('layouts.print')
@section('page-title', 'Statutes')
@section('table-headings-row')
    <tr>
            <th>Number</th>
            <th>Name</th>
            <th>Eligible</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->number }}</td>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->eligible }}</td>
                </tr>
    @endforeach
@endsection
