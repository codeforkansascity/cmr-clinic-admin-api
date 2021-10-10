@extends('layouts.print')
@section('page-title', 'Charge Codes')
@section('table-headings-row')
    <tr>
            <th>Mshp Version Id</th>
            <th>Legacy Charge Code</th>
            <th>Charge Type</th>
            <th>Classification</th>
            <th>Effective Date</th>
            <th>Inactive Date</th>
            <th>Short Description</th>
            <th>Charge Code</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->mshp_version_id }}</td>
                    <td>{{ $obj->legacy_charge_code }}</td>
                    <td>{{ $obj->charge_type }}</td>
                    <td>{{ $obj->classification }}</td>
                    <td>{{ $obj->effective_date }}</td>
                    <td>{{ $obj->inactive_date }}</td>
                    <td>{{ $obj->short_description }}</td>
                    <td>{{ $obj->charge_code }}</td>
                </tr>
    @endforeach
@endsection
