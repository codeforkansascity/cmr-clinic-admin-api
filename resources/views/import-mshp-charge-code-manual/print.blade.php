@extends('layouts.print')
@section('page-title', 'Charge Codes')
@section('table-headings-row')
    <tr>
            <th>Mshp Version Id</th>
            <th>Charge Code</th>
            <th>Ncic Mod</th>
            <th>State Mod</th>
            <th>Description</th>
            <th>Type Class</th>
            <th>Dna</th>
            <th>Sor</th>
            <th>Roc</th>
        </tr>
@endsection
@section('table-data-rows')
    @foreach($data as $obj)
        <tr>
                    <td>{{ $obj->mshp_version_id }}</td>
                    <td>{{ $obj->charge_code }}</td>
                    <td>{{ $obj->ncic_mod }}</td>
                    <td>{{ $obj->state_mod }}</td>
                    <td>{{ $obj->description }}</td>
                    <td>{{ $obj->type_class }}</td>
                    <td>{{ $obj->dna }}</td>
                    <td>{{ $obj->sor }}</td>
                    <td>{{ $obj->roc }}</td>
                </tr>
    @endforeach
@endsection
