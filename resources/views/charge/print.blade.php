@extends('layouts.print')
@section('page-title', 'Charges')
@section('table-headings-row')
    <tr>
            <th>Notes</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->notes }}</td>
                </tr>
    @endforeach
@endsection
