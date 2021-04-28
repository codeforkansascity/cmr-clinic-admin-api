@extends('layouts.print')
@section('page-title', 'Exceptions')
@section('table-headings-row')
    <tr>
            <th>Section</th>
            <th>Name</th>
            <th>Short Name</th>
            <th>Attorney Note</th>
            <th>Dyi Note</th>
            <th>Logic</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->section }}</td>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->short_name }}</td>
                    <td>{{ $obj->attorney_note }}</td>
                    <td>{{ $obj->dyi_note }}</td>
                    <td>{{ $obj->logic }}</td>
                </tr>
    @endforeach
@endsection
