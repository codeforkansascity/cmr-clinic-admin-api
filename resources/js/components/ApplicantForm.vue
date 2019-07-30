<template>
    <div>
        <div
            class="alert alert-danger"
            role="alert"
            v-if="server_message !== false"
        >
            {{ this.server_message }}
            <a href="/login" v-if="try_logging_in">Login</a>
        </div>
        <div class="row">
            <div class="col-md-12" style="padding-left: 1em; display: flex; align-items: center; justify-content: space-between; ">
                <h2 style="display: inline-block;">{{ form_data.name }}    {{ form_data.dob }}</h2>
                <div>
                    <img class="help-button d-print-none" src="/img/icons/noun_collapse_2091048_000000.png" style="width: 1.8em"
                         v-on:click="isShowing ^= true" v-show="isShowing">
                    <img class="help-button d-print-none" src="/img/icons/noun_expand_1211939_000000.png" style="width: 1.5em; margin-bottom: 1em"
                         v-on:click="isShowing ^= true" v-show="!isShowing">
                </div>
            </div>
        </div>
        <div class="row">
        </div>
        <div class="row" v-show="!isShowing">
            <div class="col-md-12" style="padding-left: 1em;">
                {{ form_data.notes }}
            </div>
        </div>
        <form @submit.prevent="handleSubmit" class="form-horizontal" v-show="isShowing">
            <div class="row">
                <div class="col-md-6" style="padding-left: 1em;">
                    <div class="col-md-12">
                        <std-form-group
                            :errors="form_errors.name"
                            :required="true"
                            label="What is your full name?"
                            label-for="name"
                        >
                            <fld-input name="name" required v-model="form_data.name" />
                            <template slot="help">
                                Name must be unique.
                            </template>
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                            :errors="form_errors.sex"
                            label="Sex"
                            label-for="sex"
                        >
                            <fld-input name="sex" v-model="form_data.sex" />
                        </std-form-group>
                    </div>

                    <!--<input-select-other field="sex" v-bind:options="sex_options">What is your sex</input-select-other>-->
                    <!--<input-select-other field="race" v-bind:options="race_options">What is your race?</input-select-other>-->
                    <div class="col-md-12">
                        <std-form-group
                            :errors="form_errors.race"
                            label="Race"
                            label-for="race"
                        >
                            <fld-input name="race" v-model="form_data.race" />
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                            :errors="form_errors.race"
                            label="Previous Expungements"
                            label-for="previous_expungements"
                        >
                            <fld-text-area field="previous_expungements">
                            </fld-text-area>
                            <template slot="help">
                                Leave blank or enter state court and case number of previous expungements.
                            </template>
                        </std-form-group>
                    </div>


                </div>
                <div class="col-md-6" style="padding-left: 1em;">
                    <div class="col-md-12">
                        <std-form-group
                            :errors="form_errors.dob"
                            label="Date of Birth"
                            label-for="dob"
                        >
                            <fld-input name="dob" v-model="form_data.dob" />
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                            :errors="form_errors.phone"
                            label="Phone/Cell"
                            label-for="phone"
                        >
                            <fld-input name="phone" v-model="form_data.phone" />
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                            :errors="form_errors.email"
                            label="Email"
                            label-for="email"
                        >
                            <fld-input name="email" v-model="form_data.email" />
                        </std-form-group>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="padding-left: 1em;">
                    <fieldset>
                        <legend>Driver’s License information</legend>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.license_number"
                                label="License Number"
                                label-for="license_number"
                            >
                                <fld-input
                                    name="license_number"
                                    v-model="form_data.license_number"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.license_issuing_state"
                                label="Issuing State"
                                label-for="license_issuing_state"
                            >
                                <fld-input
                                    name="license_issuing_state"
                                    v-model="form_data.license_issuing_state"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.license_expiration_date"
                                label="Expiration Date"
                                label-for="license_expiration_date"
                            >
                                <fld-input
                                    name="license_expiration_date"
                                    v-model="form_data.license_expiration_date"
                                />
                            </std-form-group>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Filing</legend>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.county_name"
                                label="County Name"
                                label-for="county_name"
                            >
                                <fld-input
                                    name="county_name"
                                    v-model="form_data.county_name"
                                />
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.filing_court"
                                label="Filing Court"
                                label-for="filing_court"
                            >
                                <fld-input
                                    name="filing_court"
                                    v-model="form_data.filing_court"
                                />
                                <template slot="help">
                                    Court where expungement will be filed.
                                </template>
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.judicial_circuit_number"
                                label="Judicial Circuit Number"
                                label-for="judicial_circuit_number"
                            >
                                <fld-input
                                    name="judicial_circuit_number"
                                    v-model="form_data.judicial_circuit_number"
                                />
                            </std-form-group>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6" style="padding-left: 1em;">
                    <fieldset>
                        <legend>Current Address</legend>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.address_line_1"
                                label="Address Line 1"
                                label-for="address_line_1"
                            >
                                <fld-input
                                    name="address_line_1"
                                    v-model="form_data.address_line_1"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.address_line_2"
                                label="Address Line 2"
                                label-for="address_line_2"
                            >
                                <fld-input
                                    name="address_line_2"
                                    v-model="form_data.address_line_2"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.city"
                                label="City"
                                label-for="city"
                            >
                                <fld-input name="city" v-model="form_data.city" />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.state"
                                label="State"
                                label-for="state"
                            >
                                <fld-input name="state" v-model="form_data.state" />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.zip_code"
                                label="Zip Code"
                                label-for="zip_code"
                            >
                                <fld-input name="zip_code" v-model="form_data.zip_code" />
                            </std-form-group>
                        </div>
                    </fieldset>
                </div>

                <div class="col-md-6" style="padding-left: 1em;">
                    <fieldset>
                        <legend>CMS</legend>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.cms_client_number"
                                label="Cms Client Number"
                                label-for="cms_client_number"
                            >
                                <fld-input
                                    name="cms_client_number"
                                    v-model="form_data.cms_client_number"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.cms_matter_number"
                                label="Cms Matter Number"
                                label-for="cms_matter_number"
                            >
                                <fld-input
                                    name="cms_matter_number"
                                    v-model="form_data.cms_matter_number"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                :errors="form_errors.assignment_id"
                                label="Person Assigned"
                                label-for="assignment_id"
                            >
                                <fld-input
                                    name="assignment_id"
                                    v-model="form_data.assignment_id"
                                />
                            </std-form-group>
                        </div>
                    </fieldset>
                </div>
            </div>


            <!--sss-->
            <!--sss-->
            <!--sss-->


            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Count Name"-->
            <!--label-for="count_name"-->
            <!--:errors="form_errors.count_name"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="count_name"-->
            <!--v-model="form_data.count_name"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Judge Name"-->
            <!--label-for="judge_name"-->
            <!--:errors="form_errors.judge_name"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="judge_name"-->
            <!--v-model="form_data.judge_name"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Division Name"-->
            <!--label-for="division_name"-->
            <!--:errors="form_errors.division_name"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="division_name"-->
            <!--v-model="form_data.division_name"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Petitioner Name"-->
            <!--label-for="petitioner_name"-->
            <!--:errors="form_errors.petitioner_name"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="petitioner_name"-->
            <!--v-model="form_data.petitioner_name"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Division Number"-->
            <!--label-for="division_number"-->
            <!--:errors="form_errors.division_number"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="division_number"-->
            <!--v-model="form_data.division_number"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="City Name Here"-->
            <!--label-for="city_name_here"-->
            <!--:errors="form_errors.city_name_here"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="city_name_here"-->
            <!--v-model="form_data.city_name_here"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->

            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Arresting County"-->
            <!--label-for="arresting_county"-->
            <!--:errors="form_errors.arresting_county"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="arresting_county"-->
            <!--v-model="form_data.arresting_county"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Prosecuting County"-->
            <!--label-for="prosecuting_county"-->
            <!--:errors="form_errors.prosecuting_county"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="prosecuting_county"-->
            <!--v-model="form_data.prosecuting_county"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Arresting Municipality"-->
            <!--label-for="arresting_municipality"-->
            <!--:errors="form_errors.arresting_municipality"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="arresting_municipality"-->
            <!--v-model="form_data.arresting_municipality"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Other Agencies Name"-->
            <!--label-for="other_agencies_name"-->
            <!--:errors="form_errors.other_agencies_name"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="other_agencies_name"-->
            <!--v-model="form_data.other_agencies_name"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Previous Expungements"-->
            <!--label-for="previous_expungements"-->
            <!--:errors="form_errors.previous_expungements"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="previous_expungements"-->
            <!--v-model="form_data.previous_expungements"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Notes"-->
            <!--label-for="notes"-->
            <!--:errors="form_errors.notes"-->
            <!--&gt;-->
            <!--<fld-input name="notes" v-model="form_data.notes"/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="External Ref"-->
            <!--label-for="external_ref"-->
            <!--:errors="form_errors.external_ref"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="external_ref"-->
            <!--v-model="form_data.external_ref"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Any Pending Cases"-->
            <!--label-for="any_pending_cases"-->
            <!--:errors="form_errors.any_pending_cases"-->
            <!--&gt;-->
            <!--<fld-input-->
            <!--name="any_pending_cases"-->
            <!--v-model="form_data.any_pending_cases"-->
            <!--/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->
            <!---->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Status Id"-->
            <!--label-for="status_id"-->
            <!--:errors="form_errors.status_id"-->
            <!--&gt;-->
            <!--<fld-input name="status_id" v-model="form_data.status_id"/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->
            <!---->

            <!--<div class="row">-->
            <!---->
            <!--</div>-->

            <!--<div class="row">-->
            <!---->
            <!--</div>-->

            <!--<div class="row">-->

            <!--</div>-->

            <!--<div class="row">-->
            <!--<div class="col-md-12">-->
            <!--<std-form-group-->
            <!--label="Step Id"-->
            <!--label-for="step_id"-->
            <!--:errors="form_errors.step_id"-->
            <!--&gt;-->
            <!--<fld-input name="step_id" v-model="form_data.step_id"/>-->
            <!--</std-form-group>-->
            <!--</div>-->
            <!--</div>-->

            <div class="form-group mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <button
                            :disabled="processing"
                            class="btn btn-primary"
                            type="submit"
                        >
                            <span v-if="this.form_data.id">Change</span>
                            <span v-else="this.form_data.id">Add</span>
                        </button>
                    </div>
                    <div class="col-md-6 text-md-right mt-2 mt-md-0">
                        <a class="btn btn-default" href="/applicant">Cancel</a>
                    </div>
                </div>
            </div>


        </form>
        <div class="row">
            <div class="col-md-12">
                <cases :client_id="this.form_data.id"
                       :csrf_token="this.csrf_token"
                       :records="this.form_data.conviction"></cases>
            </div>
        </div>
    </div>
</template>

<style>
    fieldset {
        border: 2px solid saddlebrown !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width: inherit; /* Or auto */
        padding: 0 10px; /* To give a bit of padding on the left and right */
        border-bottom: none;
    }
</style>

<script>
    import axios from 'axios';

    export default {
        name: 'ApplicantForm',
        props: {
            record: {
                type: [Boolean, Object],
                default: false,
            },
            csrf_token: {
                type: String,
                default: '',
            },
        },
        data() {
            return {
                form_data: {
                    // _method: 'patch',
                    _token: this.csrf_token,
                    id: 0,
                    name: '',
                    phone: '',
                    email: '',
                    sex: '',
                    race: '',
                    dob_text: '',
                    address_line_1: '',
                    address_line_2: '',
                    city: '',
                    state: '',
                    zip_code: '',
                    license_number: '',
                    license_issuing_state: '',
                    license_expiration_date_text: '',
                    filing_court: '',
                    judicial_circuit_number: '',
                    count_name: '',
                    judge_name: '',
                    division_name: '',
                    petitioner_name: '',
                    division_number: '',
                    city_name_here: '',
                    county_name: '',
                    arresting_county: '',
                    prosecuting_county: '',
                    arresting_municipality: '',
                    other_agencies_name: '',
                    previous_expungements: '',
                    notes: '',
                    external_ref: '',
                    any_pending_cases: '',
                    deleted_at: '',
                    status_id: 0,
                    dob: null,
                    license_expiration_date: null,
                    cms_client_number: '',
                    cms_matter_number: '',
                    assignment_id: 0,
                    step_id: 0,
                },
                form_errors: {
                    id: false,
                    name: false,
                    phone: false,
                    email: false,
                    sex: false,
                    race: false,
                    dob_text: false,
                    address_line_1: false,
                    address_line_2: false,
                    city: false,
                    state: false,
                    zip_code: false,
                    license_number: false,
                    license_issuing_state: false,
                    license_expiration_date_text: false,
                    filing_court: false,
                    judicial_circuit_number: false,
                    count_name: false,
                    judge_name: false,
                    division_name: false,
                    petitioner_name: false,
                    division_number: false,
                    city_name_here: false,
                    county_name: false,
                    arresting_county: false,
                    prosecuting_county: false,
                    arresting_municipality: false,
                    other_agencies_name: false,
                    previous_expungements: false,
                    notes: false,
                    external_ref: false,
                    any_pending_cases: false,
                    deleted_at: false,
                    status_id: false,
                    dob: false,
                    license_expiration_date: false,
                    cms_client_number: false,
                    cms_matter_number: false,
                    assignment_id: false,
                    step_id: false,
                },
                server_message: false,
                try_logging_in: false,
                processing: false,
                isShowing: false,
            };
        },
        mounted() {
            if (this.record !== false) {
                // this.form_data._method = 'patch';
                Object.keys(this.record).forEach(
                    i => (this.form_data[i] = this.record[i]),
                );
            } else {
                // this.form_data._method = 'post';
            }
        },
        methods: {
            async handleSubmit() {
                this.server_message = false;
                this.processing = true;
                let url = '';
                let amethod = '';
                if (this.form_data.id) {
                    url = '/applicant/' + this.form_data.id;
                    amethod = 'put';
                } else {
                    url = '/applicant';
                    amethod = 'post';
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.form_data,
                }).then(res => {
                    if (res.status === 200) {
                        window.location = '/applicant';
                    } else {
                        this.server_message = res.status;
                    }
                }).catch(error => {
                    if (error.response) {
                        if (error.response.status === 422) {
                            // Clear errors out
                            Object.keys(this.form_errors).forEach(
                                i => (this.form_errors[i] = false),
                            );
                            // Set current errors
                            Object.keys(error.response.data.errors).forEach(
                                i =>
                                    (this.form_errors[i] =
                                        error.response.data.errors[i]),
                            );
                        } else if (error.response.status === 404) {
                            // Record not found
                            this.server_message = 'Record not found';
                            window.location = '/applicant';
                        } else if (error.response.status === 419) {
                            // Unknown status
                            this.server_message =
                                'Unknown Status, please try to ';
                            this.try_logging_in = true;
                        } else if (error.response.status === 500) {
                            // Unknown status
                            this.server_message =
                                'Server Error, please try to ';
                            this.try_logging_in = true;
                        } else {
                            this.server_message = error.response.data.message;
                        }
                    } else {
                        console.log(error.response);
                        this.server_message = error;
                    }
                    this.processing = false;
                });
            },
        },
    };
</script>
