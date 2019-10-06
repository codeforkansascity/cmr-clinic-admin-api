{{--

Form Lable and Errors

$fld is the field name to be returned normaly name
$label if the label
slot is the actual input statment

Example:

<div class="row">
    <div class="col-md-9">
        @component('../components/std-form-group', ['fld' => 'name', 'label' => 'Business/Firm Name'])
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
        @endcomponent
    </div>


--}}


<div class="form-group{{ $errors->has($fld) ? ' has-error' : '' }}">

    <label class="control-label">{{ $label }}</label>

    {{ $slot }}

    @if ($errors->has($fld))
        <span class="help-block">
            <strong>{{ $errors->first($fld) }}</strong>
        </span>
    @endif
</div>