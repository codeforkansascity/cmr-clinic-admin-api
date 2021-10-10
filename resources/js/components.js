/*
     SUPPORT FUNCTIONS
 */

import VuePassword from 'vue-password/dist/custom';

/*
     Application
 */

Vue.component('ss-grid-column-header', './components/SS/SsGridColumnHeader.vue');
Vue.component('ss-grid-pagination', './components/SS/SsGridPagination.vue');
Vue.component('ss-grid-pagination-location', './components/SS/SsPaginationLocation.vue');
Vue.component('search-form-group', './components/SS/SearchFormGroup.vue');


Vue.component('std-form-group', () => import(/* webpackChunkName:"std-form-group" */ './components/SS/StdFormGroup.vue'));

/*
     UI
 */
Vue.component('ui-field-view', require('./components/SS/UiFieldView.vue'));
Vue.component('ui-select-pick-one', require('./components/SS/UiSelectPickOne.vue'));
Vue.component('ui-pick-roles', () => import(/* webpackChunkName:"ui-pick-roles" */ './components/SS/UiPickRoles.vue'));

Vue.component('fld-input', () => import(/* webpackChunkName:"fld-input" */ './components/SS/FldInput.vue'));

/*
    User Invite
 */
Vue.component('create-password-form', () => import(/* webpackChunkName:"create-password-form" */ './components/invite/CreatePasswordForm.vue'));
//Vue.component('invite-grid',       require('./components/InviteGrid.vue'));    // May need to add .default);
Vue.component('invite-grid', () => import(/* webpackChunkName:"invite-grid" */ './components/InviteGrid.vue'));

/*
    Change Password
 */
Vue.component('change-password-form', () => import(/* webpackChunkName:"change-password-form" */ './components/change-password/ChangePasswordForm.vue'));

Vue.component('role-grid', () => import(/* webpackChunkName:"role-grid" */ './components/RoleGrid.vue'));


// Password strength library
Vue.component('VuePassword', () => import('vue-password'));

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

Vue.component('fld-petition-no', () => import(/* webpackChunkName:"fld-petition-no" */ './components/SS/FldPetitionNo.vue'));
Vue.component('fld-group-no', () => import(/* webpackChunkName:"fld-group-no" */ './components/SS/FldGroupNo.vue'));
Vue.component('fld-group-seq', () => import(/* webpackChunkName:"fld-group-seq" */ './components/SS/FldGroupSeq.vue'));


// fld-service may be dead code.
// Vue.component('fld-service', () => import(/* webpackChunkName:"fld-service" */ './components/SS/FldService.vue'));

Vue.component('dsp-boolean', () => import(/* webpackChunkName:"dsp-boolean" */ './components/SS/DspBoolean.vue'));
Vue.component('dsp-textarea', () => import(/* webpackChunkName:"dsp-textarea" */ './components/SS/DspTextArea.vue'));
Vue.component('dsp-text', () => import(/* webpackChunkName:"dsp-text" */ './components/SS/DspText.vue'));
Vue.component('dsp-case-badge', () => import(/* webpackChunkName:"dsp-case-badge" */ './components/SS/DspCaseBadge.vue'));
Vue.component('dsp-date', () => import(/* webpackChunkName:"dsp-date" */ './components/SS/DspDate.vue'));
Vue.component('dsp-date-time', () => import(/* webpackChunkName:"dsp-date-time" */ './components/SS/DspDateTime.vue'));
Vue.component('dsp-statute', () => import(/* webpackChunkName:"dsp-statute" */ './components/SS/DspStatute.vue'));
Vue.component('dsp-exception', () => import(/* webpackChunkName:"dsp-statute" */ './components/SS/DspException.vue'));


Vue.component('tr-view', () => import(/* webpackChunkName:"tr-view" */ './components/SS/TrView.vue'));
Vue.component('tr-view-date', () => import(/* webpackChunkName:"tr-view-date" */ './components/SS/TrViewDate.vue'));
Vue.component('tr-view-yn', () => import(/* webpackChunkName:"tr-view-yn" */ './components/SS/TrViewYN.vue'));

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

Vue.component('applicant-add', () => import(/* webpackChunkName:"applicant-add" */ './components/applicants/ApplicantAdd.vue'));
Vue.component('applicant-form', () => import(/* webpackChunkName:"applicant-form" */ './components/applicants/ApplicantForm.vue'));
Vue.component('applicant-show', () => import(/* webpackChunkName:"applicant-show" */ './components/applicants/ApplicantShow.vue'));


Vue.component('preview', () => import(/* webpackChunkName:"preview" */ './components/preview/Preview.vue'));
Vue.component('petition', () => import(/* webpackChunkName:"petition" */ './components/petition/Petition.vue'));

Vue.component('pre-api-field', () => import(/* webpackChunkName:"pre-api-field" */ './components/preview/pre-api-field.vue'));
Vue.component('pre-api-input-field', () => import(/* webpackChunkName:"pre-api-input-field" */ './components/preview/pre-api-input-field.vue'));
Vue.component('pre-field', () => import(/* webpackChunkName:"pre-field" */ './components/preview/pre-field.vue'));

Vue.component('pre-address-field', () => import(/* webpackChunkName:"pre-address-field" */ './components/preview/pre-address-field.vue'));
Vue.component('pre-date-field', () => import(/* webpackChunkName:"pre-date-field" */ './components/preview/pre-date-field.vue'));
Vue.component('pre-input-field', () => import(/* webpackChunkName:"pre-input-field" */ './components/preview/pre-input-field.vue'));

//Vue.component('status-grid',       require('./components/StatusGrid.vue'));    // May need to add .default);
//Vue.component('status-form',       require('./components/StatusForm.vue'));    // May need to add .default);
Vue.component('status-grid', () => import(/* webpackChunkName:"status-grid" */ './components/statuses/StatusGrid.vue'));
Vue.component('status-form', () => import(/* webpackChunkName:"status-form" */ './components/statuses/StatusForm.vue'));
Vue.component('status-show', () => import(/* webpackChunkName:"status-show" */ './components/statuses/StatusShow.vue'));

//Vue.component('assignment-grid',       require('./components/AssignmentGrid.vue'));    // May need to add .default);
//Vue.component('assignment-form',       require('./components/AssignmentForm.vue'));    // May need to add .default);
Vue.component('assignment-grid', () => import(/* webpackChunkName:"assignment-grid" */ './components/assignments/AssignmentGrid.vue'));
Vue.component('assignment-form', () => import(/* webpackChunkName:"assignment-form" */ './components/assignments/AssignmentForm.vue'));
Vue.component('assignment-show', () => import(/* webpackChunkName:"assignment-show" */ './components/assignments/AssignmentShow.vue'));

//Vue.component('step-grid',       require('./components/StepGrid.vue'));    // May need to add .default);
//Vue.component('step-form',       require('./components/StepForm.vue'));    // May need to add .default);
Vue.component('step-grid', () => import(/* webpackChunkName:"step-grid" */ './components/steps/StepGrid.vue'));
Vue.component('step-form', () => import(/* webpackChunkName:"step-form" */ './components/steps/StepForm.vue'));
Vue.component('step-show', () => import(/* webpackChunkName:"step-show" */ './components/steps/StepShow.vue'));

//Vue.component('statute-grid',       require('./components/StatuteGrid.vue'));    // May need to add .default);
//Vue.component('statute-form',       require('./components/StatuteForm.vue'));    // May need to add .default);
Vue.component('statute-grid', () => import(/* webpackChunkName:"statute-grid" */ './components/statutes/StatuteGrid.vue'));
Vue.component('statute-form', () => import(/* webpackChunkName:"statute-form" */ './components/statutes/StatuteForm.vue'));
Vue.component('statute-show', () => import(/* webpackChunkName:"statute-show" */ './components/statutes/StatuteShow.vue'));

//Vue.component('comment-grid',       require('./components/CommentGrid.vue'));    // May need to add .default);
//Vue.component('comment-form',       require('./components/CommentForm.vue'));    // May need to add .default);
Vue.component('comment-grid', () => import(/* webpackChunkName:"comment-grid" */ './components/comments/CommentGrid.vue'));
Vue.component('comment-form', () => import(/* webpackChunkName:"comment-form" */ './components/comments/CommentForm.vue'));
Vue.component('comment-show', () => import(/* webpackChunkName:"comment-show" */ './components/comments/CommentShow.vue'));

//Vue.component('user-grid',       require('./components/UserGrid.vue'));    // May need to add .default);
//Vue.component('user-form',       require('./components/UserForm.vue'));    // May need to add .default);
Vue.component('user-grid', () => import(/* webpackChunkName:"user-grid" */ './components/User/UserGrid.vue'));
Vue.component('user-form', () => import(/* webpackChunkName:"user-form" */ './components/User/UserForm.vue'));
Vue.component('user-show', () => import(/* webpackChunkName:"user-show" */ './components/User/UserShow.vue'));

//Vue.component('role-description-grid',       require('./components/RoleDescriptionGrid.vue'));    // May need to add .default);
//Vue.component('role-description-form',       require('./components/RoleDescriptionForm.vue'));    // May need to add .default);
Vue.component('role-description-grid', () => import(/* webpackChunkName:"role-description-grid" */ './components/RoleDescription/RoleDescriptionGrid.vue'));
Vue.component('role-description-form', () => import(/* webpackChunkName:"role-description-form" */ './components/RoleDescription/RoleDescriptionForm.vue'));
Vue.component('role-description-show', () => import(/* webpackChunkName:"role-description-show" */ './components/RoleDescription/RoleDescriptionShow.vue'));


//Vue.component('service-grid',       require('./components/ServiceGrid.vue'));    // May need to add .default);
//Vue.component('service-form',       require('./components/ServiceForm.vue'));    // May need to add .default);
Vue.component('service-grid', () => import(/* webpackChunkName:"service-grid" */ './components/services/ServiceGrid.vue'));
Vue.component('service-form', () => import(/* webpackChunkName:"service-form" */ './components/services/ServiceForm.vue'));
Vue.component('service-show', () => import(/* webpackChunkName:"service-show" */ './components/services/ServiceShow.vue'));

Vue.component('service-type-grid', () => import(/* webpackChunkName:"service-type-grid" */ './components/service_types/ServiceTypeGrid.vue'));
Vue.component('service-type-form', () => import(/* webpackChunkName:"service-type-form" */ './components/service_types/ServiceTypeForm.vue'));
Vue.component('service-type-show', () => import(/* webpackChunkName:"service-type-show" */ './components/service_types/ServiceTypeShow.vue'));


Vue.component('data-source-grid', () => import(/* webpackChunkName:"data-source-grid" */ './components/data_sources/DataSourceGrid.vue'));
Vue.component('data-source-form', () => import(/* webpackChunkName:"data-source-form" */ './components/data_sources/DataSourceForm.vue'));
Vue.component('data-source-show', () => import(/* webpackChunkName:"data-source-show" */ './components/data_sources/DataSourceShow.vue'));
Vue.component('fld-source-select',  () => import(/* webpackChunkName:"fld-source-select" */ './components/SS/FldSourceSelect'));


Vue.component('Uploader', () => import(/* webpackChunkName:"Uploader" */ './components/Uploader.vue'));
Vue.component('photo-uploader', () => import(/* webpackChunkName:"photo-uploader" */ './components/PhotoUploader.vue'));

Vue.component('jurisdiction-grid', () => import(/* webpackChunkName:"jurisdiction-grid" */ './components/jurisdiction/JurisdictionGrid.vue'));
Vue.component('jurisdiction-form', () => import(/* webpackChunkName:"jurisdiction-form" */ './components/jurisdiction/JurisdictionForm.vue'));
Vue.component('jurisdiction-show', () => import(/* webpackChunkName:"jurisdiction-show" */ './components/jurisdiction/JurisdictionShow.vue'));


Vue.component('jurisdiction-type-grid', () => import(/* webpackChunkName:"jurisdiction-type-grid" */ './components/jurisdiction_types/JurisdictionTypeGrid.vue'));
Vue.component('jurisdiction-type-form', () => import(/* webpackChunkName:"jurisdiction-type-form" */ './components/jurisdiction_types/JurisdictionTypeForm.vue'));
Vue.component('jurisdiction-type-show', () => import(/* webpackChunkName:"jurisdiction-type-show" */ './components/jurisdiction_types/JurisdictionTypeShow.vue'));

Vue.component('jurisdiction-create-modal', () => import(/* webpackChunkName:"jurisdiction-create-modal" */ './components/jurisdiction/JurisdictionCreateModal'));


Vue.component('petition-field-grid', () => import(/* webpackChunkName:"petition-field-grid" */ './components/petition_fields/PetitionFieldGrid.vue'));
Vue.component('petition-field-form', () => import(/* webpackChunkName:"petition-field-form" */ './components/petition_fields/PetitionFieldForm.vue'));
Vue.component('petition-field-show', () => import(/* webpackChunkName:"petition-field-show" */ './components/petition_fields/PetitionFieldShow.vue'));

Vue.component('exception-grid', () => import(/* webpackChunkName:"exception-grid" */ './components/exceptions/ExceptionGrid.vue'));
Vue.component('exception-form', () => import(/* webpackChunkName:"exception-form" */ './components/exceptions/ExceptionForm.vue'));
Vue.component('exception-show', () => import(/* webpackChunkName:"exception-show" */ './components/exceptions/ExceptionShow.vue'));

Vue.component('dsp-exception-statutes', () => import(/* webpackChunkName:"dsp-exception-statutes" */ './components/statute_exceptions/DspExceptionStatutes.vue'));


Vue.component('import-mshp-charge-code-manual-grid', () => import(/* webpackChunkName:"import-mshp-charge-code-manual-grid" */ './components/import_mshp_charge_code_manuals/ImportMshpChargeCodeManualGrid.vue'));
Vue.component('import-mshp-charge-code-manual-form', () => import(/* webpackChunkName:"import-mshp-charge-code-manual-form" */ './components/import_mshp_charge_code_manuals/ImportMshpChargeCodeManualForm.vue'));
Vue.component('import-mshp-charge-code-manual-show', () => import(/* webpackChunkName:"import-mshp-charge-code-manual-Show" */ './components/import_mshp_charge_code_manuals/ImportMshpChargeCodeManualShow.vue'));
Vue.component('import-mshp-charge-code-grid', () => import(/* webpackChunkName:"import-mshp-charge-code-grid" */ './components/import_mshp_charge_codes/ImportMshpChargeCodeGrid.vue'));
Vue.component('import-mshp-charge-code-form', () => import(/* webpackChunkName:"import-mshp-charge-code-form" */ './components/import_mshp_charge_codes/ImportMshpChargeCodeForm.vue'));
Vue.component('import-mshp-charge-code-show', () => import(/* webpackChunkName:"import-mshp-charge-code-Show" */ './components/import_mshp_charge_codes/ImportMshpChargeCodeShow.vue'));