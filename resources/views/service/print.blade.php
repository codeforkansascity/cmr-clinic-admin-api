@extends('layouts.print')
@section('page-title', 'Services')
@section('table-headings-row')
    <tr>
            <th>Name</th>
            <th>Service Type Id</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->name }}</td>
                    <td>{{ $obj->service_type_id }}</td>
                </tr>
    @endforeach
@endsection
