@extends('layouts.print')
@section('page-title', 'Jurisdictions')
@section('table-headings-row')
    <tr>
        <th>Jurisdiction Type Id</th>
        <th>Name</th>
        <th>Url</th>
    </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
            <td>{{ $obj->jurisdiction_type_id }}</td>
            <td>{{ $obj->name }}</td>
            <td>{{ $obj->url }}</td>
        </tr>
    @endforeach
@endsection
