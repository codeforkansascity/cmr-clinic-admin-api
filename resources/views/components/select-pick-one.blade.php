{{--
$fld is the field name to be returned normaly model_id
$first_option is the first option in the pulldown, "Pick One" or "Select One"
$selected_id the option that is selected 
$options is a nested array where the first index is the order the options  
       [0] = ['id' => 23, 'name' => 'Alaska']
       [1] = ['id' => 11, 'name' => 'Tom']
$options is usually created with the model's `getForSelect()`

Example:

@include('helpers.select-pick-one', [
    'fld' => 'city_neighborhood_id',
    'selected_id' => $property->city_neighborhood_id,
    'first_option' => 'Select a City Neighborhood',
    'options' => $city_neighborhood_options
])




--}}
<select class="form-control" name="{{$fld}}">

    <option value="0">{{$first_option}}</option>

    @foreach($options as $option)
        @if ( $option->id == ( old('$fld') ? old('$fld') : $selected_id) )
            <option value="{{$option->id}}" SELECTED>{{$option->name}}</option>
        @else
            <option value="{{$option->id}}">{{$option->name}}</option>
        @endif
    @endforeach
</select>