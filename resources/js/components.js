Vue.component('ss-grid-column-header', './components/SsGridColumnHeader.vue');
Vue.component('ss-grid-pagination', './components/SsGridPagination.vue');
Vue.component('ss-grid-pagination-location', './components/SsPaginationLocation.vue');
Vue.component('search-form-group', './components/SearchFormGroup.vue');

Vue.component('std-form-group', () => import(/* webpackChunkName:"std-form-group" */ './components/StdFormGroup.vue'));

/*
     UI
 */
Vue.component('ui-field-view', require('./components/SS/UiFieldView.vue'));
Vue.component('ui-select-pick-one', require('./components/SS/UiSelectPickOne.vue'));

Vue.component('std-form-group', () => import(/* webpackChunkName:"std-form-group" */ './components/SS/StdFormGroup.vue'));
Vue.component('fld-input', () => import(/* webpackChunkName:"fld-input" */ './components/SS/FldInput.vue'));

// CKEditor
import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use(CKEditor);

Vue.component('fld-text-editor', () => import(/* webpackChunkName:"fld-text-editor" */ './components/SS/FldTextEditor.vue'));

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
Vue.component('dsp-date', () => import(/* webpackChunkName:"dsp-date" */ './components/SS/DspDate.vue'));

Vue.component('tr-view', () => import(/* webpackChunkName:"tr-view" */ './components/SS/TrView.vue'));

Vue.component('search-form-group', () => import(/* webpackChunkName:"search-form-group" */ './components/SS/SearchFormGroup.vue'));

Vue.component('autocomplete', () => import(/* webpackChunkName:"autocomplete" */ './components/SS/AutoComplete.vue'));
Vue.component('base-modal', () => import(/* webpackChunkName:"base-modal" */ './components/SS/BaseModal.vue'));
Vue.component('fld-statute', () => import(/* webpackChunkName:"fld-statute" */ './components/SS/FldStatute.vue'));

/*
     Application Components
 */
//Vue.component('applicant-grid',       require('./components/ApplicantGrid.vue'));    // May need to add .default);
//Vue.component('applicant-form',       require('./components/ApplicantForm.vue'));    // May need to add .default);
Vue.component('applicant-grid', () => import(/* webpackChunkName:"applicant-grid" */ './components/applicants/ApplicantGrid.vue'));
//Vue.component('applicant-form', () => import(/* webpackChunkName:"applicant-form" */ './components/ApplicantForm.vue'));
Vue.component('applicant-container', () => import(/* webpackChunkName:"applicant-container" */ './components/applicants/ApplicantContainer'));


//Vue.component('status-grid',       require('./components/StatusGrid.vue'));    // May need to add .default);
//Vue.component('status-form',       require('./components/StatusForm.vue'));    // May need to add .default);
Vue.component('status-grid', () => import(/* webpackChunkName:"status-grid" */ './components/statuses/StatusGrid.vue'));
Vue.component('status-form', () => import(/* webpackChunkName:"status-form" */ './components/statuses/StatusForm.vue'));
Vue.component('status-show', () => import(/* webpackChunkName:"status-Show" */ './components/statuses/StatusShow.vue'));

//Vue.component('assignment-grid',       require('./components/AssignmentGrid.vue'));    // May need to add .default);
//Vue.component('assignment-form',       require('./components/AssignmentForm.vue'));    // May need to add .default);
Vue.component('assignment-grid', () => import(/* webpackChunkName:"assignment-grid" */ './components/assignments/AssignmentGrid.vue'));
Vue.component('assignment-form', () => import(/* webpackChunkName:"assignment-form" */ './components/assignments/AssignmentForm.vue'));
Vue.component('assignment-show', () => import(/* webpackChunkName:"assignment-Show" */ './components/assignments/AssignmentShow.vue'));

//Vue.component('step-grid',       require('./components/StepGrid.vue'));    // May need to add .default);
//Vue.component('step-form',       require('./components/StepForm.vue'));    // May need to add .default);
Vue.component('step-grid', () => import(/* webpackChunkName:"step-grid" */ './components/steps/StepGrid.vue'));
Vue.component('step-form', () => import(/* webpackChunkName:"step-form" */ './components/steps/StepForm.vue'));
Vue.component('step-show', () => import(/* webpackChunkName:"step-Show" */ './components/steps/StepShow.vue'));

//Vue.component('statute-grid',       require('./components/StatuteGrid.vue'));    // May need to add .default);
//Vue.component('statute-form',       require('./components/StatuteForm.vue'));    // May need to add .default);
Vue.component('statute-grid', () => import(/* webpackChunkName:"statute-grid" */ './components/statutes/StatuteGrid.vue'));
Vue.component('statute-form', () => import(/* webpackChunkName:"statute-form" */ './components/statutes/StatuteForm.vue'));
Vue.component('statute-show', () => import(/* webpackChunkName:"statute-Show" */ './components/statutes/StatuteShow.vue'));

//Vue.component('comment-grid',       require('./components/CommentGrid.vue'));    // May need to add .default);
//Vue.component('comment-form',       require('./components/CommentForm.vue'));    // May need to add .default);
Vue.component('comment-grid', () => import(/* webpackChunkName:"comment-grid" */ './components/comments/CommentGrid.vue'));
Vue.component('comment-form', () => import(/* webpackChunkName:"comment-form" */ './components/comments/CommentForm.vue'));
Vue.component('comment-show', () => import(/* webpackChunkName:"comment-Show" */ './components/comments/CommentShow.vue'));


