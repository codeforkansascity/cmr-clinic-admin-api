@extends('layouts.print')
@section('page-title', '[[display_name_plural]]')
@section('table-headings-row')
    <tr>
    [[foreach:grid_columns]]
        <th>[[i.display]]</th>
    [[endforeach]]
    </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
        [[foreach:grid_columns]]
            <td>{{ $obj->[[i.name]] }}</td>
        [[endforeach]]
        </tr>
    @endforeach
@endsection
