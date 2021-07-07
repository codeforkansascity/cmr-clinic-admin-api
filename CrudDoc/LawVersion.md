# LawVersion - `lawversions`

## To create or replace missing CRUD

Updated for Laravel 7

```
php artisan make:crud lawversions  --display-name="LawVersions" --grid-columns="name"   # --force --skip-append
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
        Permission::findOrCreate('law_version index');
        Permission::findOrCreate('law_version view');
        Permission::findOrCreate('law_version export-pdf');
        Permission::findOrCreate('law_version export-excel');
        Permission::findOrCreate('law_version add');
        Permission::findOrCreate('law_version edit');
        Permission::findOrCreate('law_version delete');
```

From the bottom of the file, add these to admin

```
'law_version index',
'law_version view',
'law_version export-pdf',
'law_version export-excel',
'law_version add',
'law_version edit',
'law_version delete',
```

From the bottom of the file, add these to read-only

```
        'law_version index',
        'law_version view',
```

Then run the following to install the permissions

```
php artisan app:set-initial-permissions
```

### Components

In `resource/js/components`


Add

```
Vue.component('law-version-grid', () => import(/* webpackChunkName:"law-version-grid" */ './components/law_versions/LawVersionGrid.vue'));
Vue.component('law-version-form', () => import(/* webpackChunkName:"law-version-form" */ './components/law_versions/LawVersionForm.vue'));
Vue.component('law-version-show', () => import(/* webpackChunkName:"law-version-show" */ './components/law_versions/LawVersionShow.vue'));

```

### Routes

In `routes/web.php


Add

```
Route::get('/api-law-version', 'App\Http\Controllers\LawVersionApi@index');
Route::get('/api-law-version/options', 'App\Http\Controllers\LawVersionApi@getOptions');
Route::get('/law-version/download', 'App\Http\Controllers\LawVersionController@download')->name('law-version.download');
Route::get('/law-version/print', 'App\Http\Controllers\LawVersionController@print')->name('law-version.print');
Route::resource('/law-version', 'App\Http\Controllers\LawVersionController');
```

#### Add to the menu in `resources/views/layouts/crud-nav.blade.php`

##### Menu

```
@can(['law_version index'])
<li class="nav-item @php if(isset($nav_path[0]) && $nav_path[0] == 'law-version') echo 'active' @endphp">
    <a class="nav-link" href="{{ route('law-version.index') }}">Law Versions <span
            class="sr-only">(current)</span></a>
</li>
@endcan
```

##### Sub Menu

```
@can(['law_version index'])
<a class="dropdown-item @php if(isset($nav_path[1]) && $nav_path[1] == 'law-version') echo 'active' @endphp"
   href="/law-version">Law Versions</a>
@endcan
```



## Code Cleanup


```
app/Exports/LawVersionExport.php
app/Http/Controlers/LawVersionControler.php
app/Http/Controlers/LawVersionApi.php
app/Http/Requests/LawVersionFormRequest.php
app/Http/Requests/LawVersionIndexRequest.php
app/Lib/Import/ImportLawVersion.php
app/Observers/LawVersionObserver.php
app/LawVersion.php
resources/js/components/law_versionsresources/views/law_versions
node_modules/.bin/prettier --write resources/js/components/law_versions/" . [[modelname]] . 'Grid.vue'
node_modules/.bin/prettier --write resources/js/components/law_versions/" . [[modelname]] . 'Form.vue'
node_modules/.bin/prettier --write resources/js/components/law_versions/" . [[modelname]] . 'Show.vue'
```




## FORM Vue component example.
```
<std-form-group
    label="LawVersion"
    label-for="law_version_id"
    :errors="form_errors.law_version_id">
    <ui-select-pick-one
        url="/api-law-version/options"
        v-model="form_data.law_version_id"
        :selected_id="form_data.law_version_id"
        name="law_version_id"
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
    label="LawVersion"
    label-for="law_version_id"
    :errors="form_errors.law_version_id">
    <ui-select-pick-one
        url="/api-law-version/options"
        v-model="form_data.law_version_id"
        :selected_id="form_data.law_version_id"
        name="law_version_id"
        blank_text="-- Select One --"
        blank_value="0"
        additional_classes="mb-2 grid-filter">
    </ui-select-pick-one>
</search-form-group>
```
## Blade component example.

### In Controller

```
$law_version_options = \App\LawVersion::getOptions();
```


### In View

```
@component('../components/select-pick-one', [
'fld' => 'law_version_id',
'selected_id' => $RECORD->law_version_id,
'first_option' => 'Select a LawVersions',
'options' => $law_version_options
])
@endcomponent
```

## Old Stuff that can be ignored

#### Components

 In `resource/js/components`

Remove

```
Vue.component('law_version', require('./components/law_version.vue').default);
```

#### Remove dead code

```
rm app/Queries/GridQueries/LawVersionQuery.php
rm resources/js/components/LawVersionGrid.vue
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
