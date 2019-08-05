Vue.component('ss-grid-column-header', './components/SsGridColumnHeader.vue');
Vue.component('ss-grid-pagination', './components/SsGridPagination.vue');
Vue.component('ss-grid-pagination-location', './components/SsPaginationLocation.vue');
Vue.component('search-form-group', './components/SearchFormGroup.vue');

Vue.component('std-form-group', () => import(/* webpackChunkName:"std-form-group" */ './components/StdFormGroup.vue'));

/*
     UI
 */
Vue.component('ui-field-view', require('./components/UiFieldView.vue'));
Vue.component('ui-select-pick-one', require('./components/UiSelectPickOne.vue'));

Vue.component('std-form-group', () => import(/* webpackChunkName:"std-form-group" */ './components/SS/StdFormGroup.vue'));
Vue.component('fld-input', () => import(/* webpackChunkName:"fld-input" */ './components/SS/FldInput.vue'));
Vue.component('fld-text-area', () => import(/* webpackChunkName:"fld-text-area" */ './components/SS/FldTextArea.vue'));
Vue.component('fld-checkbox', () => import(/* webpackChunkName:"fld-checkbox" */ './components/SS/FldCheckBox.vue'));
Vue.component('fld-state', () => import(/* webpackChunkName:"fld-state" */ './components/SS/FldState.vue'));
Vue.component('fld-sex', () => import(/* webpackChunkName:"fld-sex" */ './components/SS/FldSex.vue'));
Vue.component('fld-race', () => import(/* webpackChunkName:"fld-race" */ './components/SS/FldRace.vue'));

Vue.component('fld-charge-type', () => import(/* webpackChunkName:"fld-charge-type" */ './components/SS/FldChargeType.vue'));
Vue.component('fld-charge-class', () => import(/* webpackChunkName:"fld-charge-class" */ './components/SS/FldChargeClass.vue'));
Vue.component('fld-convicted', () => import(/* webpackChunkName:"fld-convicted" */ './components/SS/FldConvicted.vue'));
Vue.component('fld-eligible', () => import(/* webpackChunkName:"fld-eligible" */ './components/SS/FldEligible.vue'));
Vue.component('fld-expunge', () => import(/* webpackChunkName:"fld-expunge" */ './components/SS/FldExpunge.vue'));





Vue.component('dsp-boolean', () => import(/* webpackChunkName:"dsp-boolean" */ './components/SS/DspBoolean.vue'));
Vue.component('dsp-textarea', () => import(/* webpackChunkName:"dsp-textarea" */ './components/SS/DspTextArea.vue'));
Vue.component('dsp-text', () => import(/* webpackChunkName:"dsp-text" */ './components/SS/DspText.vue'));

Vue.component('search-form-group', () => import(/* webpackChunkName:"search-form-group" */ './components/SearchFormGroup.vue'));



Vue.component('cases', () => import(/* webpackChunkName:"cases" */ './components/Cases.vue'));
Vue.component('charges', () => import(/* webpackChunkName:"charges" */ './components/Charges.vue'));

/*
     Application Components
 */
//Vue.component('applicant-grid',       require('./components/ApplicantGrid.vue'));    // May need to add .default);
//Vue.component('applicant-form',       require('./components/ApplicantForm.vue'));    // May need to add .default);
Vue.component('applicant-grid', () => import(/* webpackChunkName:"applicant-grid" */ './components/ApplicantGrid.vue'));
Vue.component('applicant-form', () => import(/* webpackChunkName:"applicant-form" */ './components/ApplicantForm.vue'));

//Vue.component('status-grid',       require('./components/StatusGrid.vue'));    // May need to add .default);
//Vue.component('status-form',       require('./components/StatusForm.vue'));    // May need to add .default);
Vue.component('status-grid', () => import(/* webpackChunkName:"status-grid" */ './components/StatusGrid.vue'));
Vue.component('status-form', () => import(/* webpackChunkName:"status-form" */ './components/StatusForm.vue'));

//Vue.component('assignment-grid',       require('./components/AssignmentGrid.vue'));    // May need to add .default);
//Vue.component('assignment-form',       require('./components/AssignmentForm.vue'));    // May need to add .default);
Vue.component('assignment-grid', () => import(/* webpackChunkName:"assignment-grid" */ './components/AssignmentGrid.vue'));
Vue.component('assignment-form', () => import(/* webpackChunkName:"assignment-form" */ './components/AssignmentForm.vue'));
Vue.component('applicant-show', () => import(/* webpackChunkName:"applicant-Show" */ './components/ApplicantShow.vue'));
Vue.component('case-grid', () => import(/* webpackChunkName:"case-grid" */ './components/CaseGrid.vue'));
Vue.component('case-form', () => import(/* webpackChunkName:"case-form" */ './components/CaseForm.vue'));
Vue.component('case-show', () => import(/* webpackChunkName:"case-Show" */ './components/CaseShow.vue'));
//Vue.component('charge-grid',       require('./components/ChargeGrid.vue'));    // May need to add .default);
//Vue.component('charge-form',       require('./components/ChargeForm.vue'));    // May need to add .default);
Vue.component('charge-grid', () => import(/* webpackChunkName:"charge-grid" */ './components/ChargeGrid.vue'));
Vue.component('charge-form', () => import(/* webpackChunkName:"charge-form" */ './components/ChargeForm.vue'));
Vue.component('charge-show', () => import(/* webpackChunkName:"charge-Show" */ './components/ChargeShow.vue'));
//Vue.component('step-grid',       require('./components/StepGrid.vue'));    // May need to add .default);
//Vue.component('step-form',       require('./components/StepForm.vue'));    // May need to add .default);
Vue.component('step-grid', () => import(/* webpackChunkName:"step-grid" */ './components/StepGrid.vue'));
Vue.component('step-form', () => import(/* webpackChunkName:"step-form" */ './components/StepForm.vue'));

Vue.component('assignment-show', () => import(/* webpackChunkName:"assignment-Show" */ './components/AssignmentShow.vue'));
Vue.component('step-show', () => import(/* webpackChunkName:"step-Show" */ './components/StepShow.vue'));
Vue.component('status-show', () => import(/* webpackChunkName:"status-Show" */ './components/StatusShow.vue'));

