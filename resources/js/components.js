Vue.component('ss-grid-column-header', './components/SsGridColumnHeader.vue');
Vue.component('ss-grid-pagination', './components/SsGridPagination.vue');
Vue.component('ss-grid-pagination-location', './components/SsPaginationLocation.vue');
Vue.component('search-form-group', './components/SearchFormGroup.vue');

Vue.component('std-form-group', () => import(/* webpackChunkName:"std-form-group" */ './components/StdFormGroup.vue'));



//Vue.component('client-grid',       require('./components/ClientGrid.vue'));    // May need to add .default);
//Vue.component('client-form',       require('./components/ClientForm.vue'));    // May need to add .default);
Vue.component('client-grid', () => import(/* webpackChunkName:"client-grid" */ './components/ClientGrid.vue'));
Vue.component('client-form', () => import(/* webpackChunkName:"client-form" */ './components/ClientForm.vue'));

//Vue.component('status-grid',       require('./components/StatusGrid.vue'));    // May need to add .default);
//Vue.component('status-form',       require('./components/StatusForm.vue'));    // May need to add .default);
Vue.component('status-grid', () => import(/* webpackChunkName:"status-grid" */ './components/StatusGrid.vue'));
Vue.component('status-form', () => import(/* webpackChunkName:"status-form" */ './components/StatusForm.vue'));

//Vue.component('assignment-grid',       require('./components/AssignmentGrid.vue'));    // May need to add .default);
//Vue.component('assignment-form',       require('./components/AssignmentForm.vue'));    // May need to add .default);
Vue.component('assignment-grid', () => import(/* webpackChunkName:"assignment-grid" */ './components/AssignmentGrid.vue'));
Vue.component('assignment-form', () => import(/* webpackChunkName:"assignment-form" */ './components/AssignmentForm.vue'));
Vue.component('client-show', () => import(/* webpackChunkName:"client-Show" */ './components/ClientShow.vue'));
//Vue.component('conviction-grid',       require('./components/ConvictionGrid.vue'));    // May need to add .default);
//Vue.component('conviction-form',       require('./components/ConvictionForm.vue'));    // May need to add .default);
Vue.component('conviction-grid', () => import(/* webpackChunkName:"conviction-grid" */ './components/ConvictionGrid.vue'));
Vue.component('conviction-form', () => import(/* webpackChunkName:"conviction-form" */ './components/ConvictionForm.vue'));
Vue.component('conviction-show', () => import(/* webpackChunkName:"conviction-Show" */ './components/ConvictionShow.vue'));
//Vue.component('charge-grid',       require('./components/ChargeGrid.vue'));    // May need to add .default);
//Vue.component('charge-form',       require('./components/ChargeForm.vue'));    // May need to add .default);
Vue.component('charge-grid', () => import(/* webpackChunkName:"charge-grid" */ './components/ChargeGrid.vue'));
Vue.component('charge-form', () => import(/* webpackChunkName:"charge-form" */ './components/ChargeForm.vue'));
Vue.component('charge-show', () => import(/* webpackChunkName:"charge-Show" */ './components/ChargeShow.vue'));
//Vue.component('step-grid',       require('./components/StepGrid.vue'));    // May need to add .default);
//Vue.component('step-form',       require('./components/StepForm.vue'));    // May need to add .default);
Vue.component('step-grid', () => import(/* webpackChunkName:"step-grid" */ './components/StepGrid.vue'));
Vue.component('step-form', () => import(/* webpackChunkName:"step-form" */ './components/StepForm.vue'));
