<?php


/**
 * Examples
 *
 * Vue component example.
 *
<ui-select-pick-one
url="/api-statutes-eligibility/options"
v-model="statutes_eligibilitySelected"
:selected_id=statutes_eligibilitySelected"
name="statutes_eligibility">
</ui-select-pick-one>
 *
 *
 * Blade component example.
 *
 *   In Controler
 *
$statutes_eligibility_options = \App\StatutesEligibility::getOptions();


 *
 *   In View

@component('../components/select-pick-one', [
'fld' => 'statutes_eligibility_id',
'selected_id' => $RECORD->statutes_eligibility_id,
'first_option' => 'Select a StatutesEligibilities',
'options' => $statutes_eligibility_options
])
@endcomponent
 *
 * Permissions
 *

Permission::create(['name' => 'statutes_eligibility index']);
Permission::create(['name' => 'statutes_eligibility add']);
Permission::create(['name' => 'statutes_eligibility update']);
Permission::create(['name' => 'statutes_eligibility view']);
Permission::create(['name' => 'statutes_eligibility destroy']);
Permission::create(['name' => 'statutes_eligibility export-pdf']);
Permission::create(['name' => 'statutes_eligibility export-excel']);

 */

namespace App\Http\Controllers;

use App\StatutesEligibility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StatutesEligibilityIndexRequest;

class StatutesEligibilityApi extends Controller
{
    /**
     * Returns "options" for HTML select
     * @return array
     */
    public function getOptions() {

        return StatutesEligibility::getOptions();
    }

}
