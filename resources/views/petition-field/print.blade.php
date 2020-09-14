@extends('layouts.print')
@section('page-title', 'Petition Fields')
@section('table-headings-row')
    <tr>
            <th>Applicant Id</th>
            <th>Petition Number</th>
            <th>Value</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->applicant_id }}</td>
                    <td>{{ $obj->petition_number }}</td>
                    <td>{{ $obj->value }}</td>
                </tr>
    @endforeach
@endsection
