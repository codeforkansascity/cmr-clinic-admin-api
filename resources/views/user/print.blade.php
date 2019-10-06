@extends('layouts.print')
@section('page-title', 'Users')
@section('table-headings-row')
    <tr>
        <th style="width:45%;">Name</th>
        <th style="width:45%;">Email</th>
        <th style="width:10%;">Active</th>
    </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
            <td>{{ $obj->name }}</td>
            <td>{{ $obj->email }}</td>
            <td>
                @if($obj->active)
                    Yes
                @endif
            </td>
        </tr>
    @endforeach
@endsection
