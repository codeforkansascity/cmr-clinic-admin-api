@extends('layouts.print')
@section('page-title', 'Law Versions')
@section('table-headings-row')
    <tr>
            <th>Number</th>
            <th>Name</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->number }}</td>
                    <td>{{ $obj->name }}</td>
                </tr>
    @endforeach
@endsection
