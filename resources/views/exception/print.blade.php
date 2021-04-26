@extends('layouts.print')
@section('page-title', 'Petition Fields')
@section('table-headings-row')
    <tr>
            <th>Section</th>
            <th>Name</th>
            <th>Short Name</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->section }}</td>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->short_name }}</td>
                </tr>
    @endforeach
@endsection
