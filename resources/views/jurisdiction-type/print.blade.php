@extends('layouts.print')
@section('page-title', 'Jurisdiction Types')
@section('table-headings-row')
    <tr>
        <th>Name</th>
        <th>Display Sequence</th>
    </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
            <td>{{ $obj->name }}</td>
            <td>{{ $obj->display_sequence }}</td>
        </tr>
    @endforeach
@endsection
