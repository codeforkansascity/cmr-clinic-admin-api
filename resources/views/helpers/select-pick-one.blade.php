{{--
$fld is the field name to be returned normaly model_id
$first_option is the first option in the pulldown, "Pick One" or "Select One"
$selected_id the option that is selected
$options is a nested array where the first index is the order the options
       [0] = ['id' => 23, 'name' => 'Alaska']
       [1] = ['id' => 11, 'name' => 'Tom']
$options is usually created with the model's `getForSelect()`

USAGE:
In this example we are creating a $invite and its role field

                    @include('helpers.select-pick-one',
                         [
                             'fld' => 'role',
                             'selected_id' => '0',
                             'first_option' => 'Select a Role',
                             'options' => $role_options
                         ])

In this example we are updating the $invite's role field,
NOTE: the selected_id in this instance is set to the value of $invite's role field

                        @include('helpers.select-pick-one',
                             [
                                 'fld' => 'role',
                                 'selected_id' => $invite->role,
                                 'first_option' => 'Select a Role',
                                 'options' => $role_options
                             ])


--}}

<select class="form-control" name="{{$fld}}">

    <option value="0">{{$first_option}}</option>

    @foreach($options as $option)
        @if ( $option->id == ( old($fld) ? old($fld) : $selected_id) )
            <option value="{{$option->id}}" SELECTED>{{$option->name}}</option>
        @else
            <option value="{{$option->id}}">{{$option->name}}</option>
        @endif
    @endforeach
</select>

