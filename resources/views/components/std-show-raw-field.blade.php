{{--

Form Lable and Errors

$fld is the field name to be returned normaly name
slot is the label

Example:

<div class="row mb-4">
    <div class="col-md-5">
        @component('../components/std-show-field', ['value' => $record->name])
            Business/Firm Name
        @endcomponent

        @component('../components/std-show-field', ['value' => $record->address])
            Address
        @endcomponent

    </div>


--}}

<div class="form-group row mb-2 mb-md-0 text-only">
    <label class="col-md-4 col-form-label text-md-right">
        {{ $slot }}
    </label>
    <div class="col-md-8">
        <span class="form-text">
            {!! $value !!}
        </span>
    </div>
</div>


