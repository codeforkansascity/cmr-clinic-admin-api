@extends('layouts.print')
@section('page-title', 'Statuses')
@section('table-headings-row')
    <tr>
            <th>Name</th>
            <th>Alias</th>
            <th>Sequence</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->alias }}</td>
                    <td>{{ $obj->sequence }}</td>
                </tr>
    @endforeach
@endsection
