<template>
    <div>
        <div
                v-if="server_message !== false"
                class="alert alert-danger"
                role="alert"
        >
            {{ this.server_message }}
            <a v-if="try_logging_in" href="/login">Login</a>
        </div>
        <div class="row">
            <div class="col-md-11" style="padding-left: 1em; ">
                <h2>{{ form_data.name }} &nbsp; &nbsp; &nbsp; &nbsp; {{
                    form_data.dob }} </h2>
            </div>
            <div class="col-md-1 text-right">
                <img v-show="isShowing" style="width: 2.8em" v-on:click="isShowing ^= true"
                     src="/img/icons/noun_chevron_2768158.png" class="help-button d-print-none">
                <img v-show="!isShowing" style="width: 2.8em; margin-bottom: 1em" v-on:click="isShowing ^= true"
                     src="/img/icons/noun_chevron_2768142.png" class="help-button d-print-none">
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
                                label="What is your full name?"
                                label-for="name"
                                :errors="form_errors.name"
                                :required="true"
                        >
                            <fld-input name="name" v-model="form_data.name" required/>
                            <template slot="help">
                                Name must be unique.
                            </template>
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                                label="Sex"
                                label-for="sex"
                                :errors="form_errors.sex"
                        >
                            <fld-sex name="sex" v-model="form_data.sex"/>
                        </std-form-group>
                    </div>

                    <!--<input-select-other field="sex" v-bind:options="sex_options">What is your sex</input-select-other>-->
                    <!--<input-select-other field="race" v-bind:options="race_options">What is your race?</input-select-other>-->
                    <div class="col-md-12">
                        <std-form-group
                                label="Race"
                                label-for="race"
                                :errors="form_errors.race"
                        >
                            <fld-race name="race" v-model="form_data.race"/>
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                                label="Previous Expungements"
                                label-for="previous_expungements"
                                :errors="form_errors.race"
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
                                label="Date of Birth"
                                label-for="dob"
                                :errors="form_errors.dob"
                        >
                            <fld-input name="dob" v-model="form_data.dob"/>
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                                label="Phone/Cell"
                                label-for="phone"
                                :errors="form_errors.phone"
                        >
                            <fld-input name="phone" v-model="form_data.phone"/>
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                                label="Email"
                                label-for="email"
                                :errors="form_errors.email"
                        >
                            <fld-input name="email" v-model="form_data.email"/>
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
                                    label="License Number"
                                    label-for="license_number"
                                    :errors="form_errors.license_number"
                            >
                                <fld-input
                                        name="license_number"
                                        v-model="form_data.license_number"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                    label="Issuing State"
                                    label-for="license_issuing_state"
                                    :errors="form_errors.license_issuing_state"
                            >
                                <fld-state
                                        name="license_issuing_state"
                                        v-model="form_data.license_issuing_state"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                    label="Expiration Date"
                                    label-for="license_expiration_date"
                                    :errors="form_errors.license_expiration_date"
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
                                    label="County Name"
                                    label-for="county_name"
                                    :errors="form_errors.county_name"
                            >
                                <fld-input
                                        name="county_name"
                                        v-model="form_data.county_name"
                                />
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Filing Court"
                                    label-for="filing_court"
                                    :errors="form_errors.filing_court"
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
                                    label="Judicial Circuit Number"
                                    label-for="judicial_circuit_number"
                                    :errors="form_errors.judicial_circuit_number"
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
                                    label="Address Line 1"
                                    label-for="address_line_1"
                                    :errors="form_errors.address_line_1"
                            >
                                <fld-input
                                        name="address_line_1"
                                        v-model="form_data.address_line_1"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                    label="Address Line 2"
                                    label-for="address_line_2"
                                    :errors="form_errors.address_line_2"
                            >
                                <fld-input
                                        name="address_line_2"
                                        v-model="form_data.address_line_2"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                    label="City"
                                    label-for="city"
                                    :errors="form_errors.city"
                            >
                                <fld-input name="city" v-model="form_data.city"/>
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                    label="State"
                                    label-for="state"
                                    :errors="form_errors.state"
                            >
                                <fld-state name="state" v-model="form_data.state"/>
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                    label="Zip Code"
                                    label-for="zip_code"
                                    :errors="form_errors.zip_code"
                            >
                                <fld-input name="zip_code" v-model="form_data.zip_code"/>
                            </std-form-group>
                        </div>
                    </fieldset>
                </div>

                <div class="col-md-6" style="padding-left: 1em;">
                    <fieldset>
                        <legend>CMS</legend>
                        <div class="col-md-12">
                            <std-form-group
                                    label="Cms Client Number"
                                    label-for="cms_client_number"
                                    :errors="form_errors.cms_client_number"
                            >
                                <fld-input
                                        name="cms_client_number"
                                        v-model="form_data.cms_client_number"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                    label="Cms Matter Number"
                                    label-for="cms_matter_number"
                                    :errors="form_errors.cms_matter_number"
                            >
                                <fld-input
                                        name="cms_matter_number"
                                        v-model="form_data.cms_matter_number"
                                />
                            </std-form-group>
                        </div>
                        <div class="col-md-12">
                            <std-form-group
                                    label="Person Assigned"
                                    label-for="assignment_id"
                                    :errors="form_errors.assignment_id"
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


            <div class="form-group mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="processing"
                        >
                            <span v-if="this.form_data.id">Change</span>
                            <span v-else="this.form_data.id">Add</span>
                        </button>
                    </div>
                    <div class="col-md-6 text-md-right mt-2 mt-md-0">
                        <a href="/applicant" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </div>


        </form>
        <div class="row">
            <div class="col-md-12">
                <cases :records="this.form_data.conviction"
                       :client_id="this.form_data.id"
                       :csrf_token="this.csrf_token"></cases>
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
    import axios from "axios";

    export default {
        name: "applicant-form",
        props: {
            record: {
                type: [Boolean, Object],
                default: false
            },
            csrf_token: {
                type: String,
                default: ""
            }
        },
        data() {
            return {
                form_data: {
                    // _method: 'patch',
                    _token: this.csrf_token,
                    id: 0,
                    name: "",
                    phone: "",
                    email: "",
                    sex: "",
                    race: "",
                    dob_text: "",
                    address_line_1: "",
                    address_line_2: "",
                    city: "",
                    state: "",
                    zip_code: "",
                    license_number: "",
                    license_issuing_state: "",
                    license_expiration_date_text: "",
                    filing_court: "",
                    judicial_circuit_number: "",
                    count_name: "",
                    judge_name: "",
                    division_name: "",
                    petitioner_name: "",
                    division_number: "",
                    city_name_here: "",
                    county_name: "",
                    arresting_county: "",
                    prosecuting_county: "",
                    arresting_municipality: "",
                    other_agencies_name: "",
                    previous_expungements: "",
                    notes: "",
                    external_ref: "",
                    any_pending_cases: "",
                    deleted_at: "",
                    status_id: 0,
                    dob: null,
                    license_expiration_date: null,
                    cms_client_number: "",
                    cms_matter_number: "",
                    assignment_id: 0,
                    step_id: 0
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
                    step_id: false
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
                    i => (this.form_data[i] = this.record[i])
                );
            } else {
                // this.form_data._method = 'post';
            }
        },
        methods: {
            async handleSubmit() {
                this.server_message = false;
                this.processing = true;
                let url = "";
                let amethod = "";
                if (this.form_data.id) {
                    url = "/applicant/" + this.form_data.id;
                    amethod = "put";
                } else {
                    url = "/applicant";
                    amethod = "post";
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.form_data
                })
                    .then(res => {
                        if (res.status === 200) {
                            window.location = "/applicant";
                        } else {
                            this.server_message = res.status;
                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            if (error.response.status === 422) {
                                // Clear errors out
                                Object.keys(this.form_errors).forEach(
                                    i => (this.form_errors[i] = false)
                                );
                                // Set current errors
                                Object.keys(error.response.data.errors).forEach(
                                    i =>
                                        (this.form_errors[i] =
                                            error.response.data.errors[i])
                                );
                            } else if (error.response.status === 404) {
                                // Record not found
                                this.server_message = "Record not found";
                                window.location = "/applicant";
                            } else if (error.response.status === 419) {
                                // Unknown status
                                this.server_message =
                                    "Unknown Status, please try to ";
                                this.try_logging_in = true;
                            } else if (error.response.status === 500) {
                                // Unknown status
                                this.server_message =
                                    "Server Error, please try to ";
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
            }
        }
    };
</script>
