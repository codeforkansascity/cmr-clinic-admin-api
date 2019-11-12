@extends('layouts.print')
@section('page-title', 'Sources')
@section('table-headings-row')
    <tr>
            <th>Name</th>
            <th>Description</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->description }}</td>
                </tr>
    @endforeach
@endsection
