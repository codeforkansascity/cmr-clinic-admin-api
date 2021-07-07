# Law - `laws`

## To create or replace missing CRUD

Updated for Laravel 7

```
php artisan make:crud laws  --display-name="Laws" --grid-columns="name"   # --force --skip-append
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
        Permission::findOrCreate('law index');
        Permission::findOrCreate('law view');
        Permission::findOrCreate('law export-pdf');
        Permission::findOrCreate('law export-excel');
        Permission::findOrCreate('law add');
        Permission::findOrCreate('law edit');
        Permission::findOrCreate('law delete');
```

From the bottom of the file, add these to admin

```
'law index',
'law view',
'law export-pdf',
'law export-excel',
'law add',
'law edit',
'law delete',
```

From the bottom of the file, add these to read-only

```
        'law index',
        'law view',
```

Then run the following to install the permissions

```
php artisan app:set-initial-permissions
```

### Components

In `resource/js/components`


Add

```
Vue.component('law-grid', () => import(/* webpackChunkName:"law-grid" */ './components/laws/LawGrid.vue'));
Vue.component('law-form', () => import(/* webpackChunkName:"law-form" */ './components/laws/LawForm.vue'));
Vue.component('law-show', () => import(/* webpackChunkName:"law-show" */ './components/laws/LawShow.vue'));

```

### Routes

In `routes/web.php


Add

```
Route::get('/api-law', 'App\Http\Controllers\LawApi@index');
Route::get('/api-law/options', 'App\Http\Controllers\LawApi@getOptions');
Route::get('/law/download', 'App\Http\Controllers\LawController@download')->name('law.download');
Route::get('/law/print', 'App\Http\Controllers\LawController@print')->name('law.print');
Route::resource('/law', 'App\Http\Controllers\LawController');
```

#### Add to the menu in `resources/views/layouts/crud-nav.blade.php`

##### Menu

```
@can(['law index'])
<li class="nav-item @php if(isset($nav_path[0]) && $nav_path[0] == 'law') echo 'active' @endphp">
    <a class="nav-link" href="{{ route('law.index') }}">Laws <span
            class="sr-only">(current)</span></a>
</li>
@endcan
```

##### Sub Menu

```
@can(['law index'])
<a class="dropdown-item @php if(isset($nav_path[1]) && $nav_path[1] == 'law') echo 'active' @endphp"
   href="/law">Laws</a>
@endcan
```



## Code Cleanup


```
app/Exports/LawExport.php
app/Http/Controlers/LawControler.php
app/Http/Controlers/LawApi.php
app/Http/Requests/LawFormRequest.php
app/Http/Requests/LawIndexRequest.php
app/Lib/Import/ImportLaw.php
app/Observers/LawObserver.php
app/Law.php
resources/js/components/lawsresources/views/laws
node_modules/.bin/prettier --write resources/js/components/laws/" . [[modelname]] . 'Grid.vue'
node_modules/.bin/prettier --write resources/js/components/laws/" . [[modelname]] . 'Form.vue'
node_modules/.bin/prettier --write resources/js/components/laws/" . [[modelname]] . 'Show.vue'
```




## FORM Vue component example.
```
<std-form-group
    label="Law"
    label-for="law_id"
    :errors="form_errors.law_id">
    <ui-select-pick-one
        url="/api-law/options"
        v-model="form_data.law_id"
        :selected_id="form_data.law_id"
        name="law_id"
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
    label="Law"
    label-for="law_id"
    :errors="form_errors.law_id">
    <ui-select-pick-one
        url="/api-law/options"
        v-model="form_data.law_id"
        :selected_id="form_data.law_id"
        name="law_id"
        blank_text="-- Select One --"
        blank_value="0"
        additional_classes="mb-2 grid-filter">
    </ui-select-pick-one>
</search-form-group>
```
## Blade component example.

### In Controller

```
$law_options = \App\Law::getOptions();
```


### In View

```
@component('../components/select-pick-one', [
'fld' => 'law_id',
'selected_id' => $RECORD->law_id,
'first_option' => 'Select a Laws',
'options' => $law_options
])
@endcomponent
```

## Old Stuff that can be ignored

#### Components

 In `resource/js/components`

Remove

```
Vue.component('law', require('./components/law.vue').default);
```

#### Remove dead code

```
rm app/Queries/GridQueries/LawQuery.php
rm resources/js/components/LawGrid.vue
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
