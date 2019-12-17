<!--

Template for GitHub Issue: Create [[controller_name]] index page

-->

# Create [[controller_name]] index/grid page PAUL

place image

## Interaction Notes

Standard index.
User is able to search
[[foreach:grid_columns]]
[[i.display]],
[[endforeach]]

## UI

* Title:  Vendors
* Component: [[view_folder]]-grid

## URL

/[[view_folder]]

## Files

* View /resources/views/[[view_folder]]/index.blade.php
* Vue /resources/js/components/[[controller_name]]Grid.vue

## API for Grid/Index

* Controler: /app/Http/Controllers/[[controller_name]]Api.php
* Method: [[controller_name]]Api::index()
* Model: /app/[[controller_name]].php
* Table: vc_vendors


### Query Parameters

* page, current page number
* keyword, text to search
* column, column to sort
* direction, direction to sort column

### Search

[[foreach:grid_columns]]
* [[i.display]]: [[i.name]]

[[endforeach]]


### Filters

None




