# Exception - `exceptions`

## To create or replace missing CRUD

Updated for Laravel 7

```
php artisan make:crud exceptions  --display-name="Exceptions" --grid-columns="name"   # --force --skip-append
```

You will want to adjust the grid-columns to add more columns  for example to add alias

```
--grid-columns="name:alias"
```

To replace one file, remove it and rerun the above command

To replace all files, uncomment `--force`


## After running Crud Generator


#### Setup Permissions in `app/Lib/InitialPermissons.php`

From the bottom of the file put these at the top in alpha order

```
        Permission::findOrCreate('exception index');
        Permission::findOrCreate('exception view');
        Permission::findOrCreate('exception export-pdf');
        Permission::findOrCreate('exception export-excel');
        Permission::findOrCreate('exception add');
        Permission::findOrCreate('exception edit');
        Permission::findOrCreate('exception delete');
```

From the bottom of the file, add these to admin

```
'exception index',
'exception view',
'exception export-pdf',
'exception export-excel',
'exception add',
'exception edit',
'exception delete',
```

From the bottom of the file, add these to read-only

```
        'exception index',
        'exception view',
```

Then run the following to install the permissions

```
php artisan app:set-initial-permissions
```

### Components

In `resource/js/components`


Add

```
Vue.component('exception-grid', () => import(/* webpackChunkName:"exception-grid" */ './components/exceptions/ExceptionGrid.vue'));
Vue.component('exception-form', () => import(/* webpackChunkName:"exception-form" */ './components/exceptions/ExceptionForm.vue'));
Vue.component('exception-show', () => import(/* webpackChunkName:"exception-show" */ './components/exceptions/ExceptionShow.vue'));

```

### Routes

In `routes/web.php


Add

```
Route::get('/api-exception', 'ExceptionApi@index');
Route::get('/api-exception/options', 'ExceptionApi@getOptions');
Route::get('/exception/download', 'ExceptionController@download')->name('exception.download');
Route::get('/exception/print', 'ExceptionController@print')->name('exception.print');
Route::resource('/exception', 'ExceptionController');
```

#### Add to the menu in `resources/views/layouts/crud-nav.blade.php`

##### Menu

```
@can(['exception index'])
<li class="nav-item @php if(isset($nav_path[0]) && $nav_path[0] == 'exception') echo 'active' @endphp">
    <a class="nav-link" href="{{ route('exception.index') }}">Petition Fields <span
            class="sr-only">(current)</span></a>
</li>
@endcan
```

##### Sub Menu

```
@can(['exception index'])
<a class="dropdown-item @php if(isset($nav_path[1]) && $nav_path[1] == 'exception') echo 'active' @endphp"
   href="/exception">Petition Fields</a>
@endcan
```



## Code Cleanup


```
app/Exports/ExceptionExport.php
app/Http/Controlers/ExceptionControler.php
app/Http/Controlers/ExceptionApi.php
app/Http/Requests/ExceptionFormRequest.php
app/Http/Requests/ExceptionIndexRequest.php
app/Lib/Import/ImportException.php
app/Observers/ExceptionObserver.php
app/Exception.php
resources/js/components/exceptionsresources/views/exceptions
node_modules/.bin/prettier --write resources/js/components/exceptions/" . [[modelname]] . 'Grid.vue'
node_modules/.bin/prettier --write resources/js/components/exceptions/" . [[modelname]] . 'Form.vue'
node_modules/.bin/prettier --write resources/js/components/exceptions/" . [[modelname]] . 'Show.vue'
```




## FORM Vue component example.
```
<std-form-group
    label="Exception"
    label-for="exception_id"
    :errors="form_errors.exception_id">
    <ui-select-pick-one
        url="/api-exception/options"
        v-model="form_data.exception_id"
        :selected_id="form_data.exception_id"
        name="exception_id"
        :blank_value="0">
    </ui-select-pick-one>
</std-form-group>


import UiSelectPickOne from "../SS/UiSelectPickOne";

components: { UiSelectPickOne },
```

## GRID Vue Component example

```
<search-form-group
    class="mb-0"
    label="Exception"
    label-for="exception_id"
    :errors="form_errors.exception_id">
    <ui-select-pick-one
        url="/api-exception/options"
        v-model="form_data.exception_id"
        :selected_id="form_data.exception_id"
        name="exception_id"
        blank_text="-- Select One --"
        blank_value="0"
        additional_classes="mb-2 grid-filter">
    </ui-select-pick-one>
</search-form-group>
```
## Blade component example.

### In Controller

```
$exception_options = \App\Exception::getOptions();
```


### In View

```
@component('../components/select-pick-one', [
'fld' => 'exception_id',
'selected_id' => $RECORD->exception_id,
'first_option' => 'Select a Exceptions',
'options' => $exception_options
])
@endcomponent
```

## Old Stuff that can be ignored

#### Components
 
 In `resource/js/components`
 
Remove

```
Vue.component('exception', require('./components/exception.vue').default);
```

#### Remove dead code

```
rm app/Queries/GridQueries/ExceptionQuery.php
rm resources/js/components/ExceptionGrid.vue
```


#### Remove from routes

```
Route::get('api/owner-all', '\\App\Queries\GridQueries\OwnerQuery@getAllForSelect');
Route::get('api/owner-one', '\\App\Queries\GridQueries\OwnerQuery@selectOne');
```

#### Remove the Grid Method
vi app/Http/Controllers/ApiController.php


```
// Begin Owner Api Data Grid Method

public function ownerData(Request $request)
{

return GridQuery::sendData($request, 'OwnerQuery');
 
}
 
// End Owner Api Data Grid Method
```
