@extends('layouts.master')
@php $nav_path = ['import-mshp-charge-code-manual']; @endphp
@section('page-title')
View {{$import_mshp_charge_code_manual->name}}
@endsection
@section('page-header-title')
View {{$import_mshp_charge_code_manual->name}}
@endsection
@section('page-header-breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('import-mshp-charge-code-manual.index') }}">Charge Codes</a></li>
    <li class="breadcrumb-item active" aria-current="location">View {{$import_mshp_charge_code_manual->name}}</li>
</ol>
@endsection
@section('content')

    <import-mshp-charge-code-manual-show :record='@json($import_mshp_charge_code_manual)'></import-mshp-charge-code-manual-show>

    <div class="row">
        <div class="col-md-12">
            <div class="row mt-4">
                <div class="col-md-4">
                    @if ($can_edit)
                        <a href="/import-mshp-charge-code-manual/{{ $import_mshp_charge_code_manual->id }}/edit" class="btn btn-primary">Edit Charge Codes</a>
                    @endif
                </div>
                <div class="col-md-4 text-md-center mt-2 mt-md-0">
                    @if ($can_delete)
                        <form class="form" role="form" method="POST" action="/import-mshp-charge-code-manual/{{ $import_mshp_charge_code_manual->id }}">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}

                            <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete Charge Codes">

                        </form>
                    @endif
                </div>
                <div class="col-md-4 text-md-right mt-2 mt-md-0">
                    <a href="{{ url('/import-mshp-charge-code-manual') }}" class="btn btn-default">Return to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function ConfirmDelete() {
        var x = confirm("Are you sure you want to delete this Charge Codes?");
        if (x)
            return true;
        else
            return false;
    }
</script>
@endsection
