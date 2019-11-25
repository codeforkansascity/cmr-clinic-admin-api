<template>
    <form @submit.prevent="handleSubmit" class="form-horizontal">
        <div
                v-if="server_message !== false"
                class="alert alert-danger"
                role="alert"
        >
            {{ this.server_message }}
            <a v-if="try_logging_in" href="/login">Login</a>
        </div>
        <h1>IS THIS USED??</h1>
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


            </div>
            <div class="col-md-6" style="padding-left: 1em;">
                <div class="col-md-12">
                    <std-form-group
                            label="Date of Birth"
                            label-for="dob"
                            :errors="form_errors.dob"
                    >
                        <!--<fld-date name="dob" v-model="form_data.dob"/>-->

                        <flat-pickr
                                v-model="form_data.dob"
                                :config="config"
                                @blur="parseDate($event, 'dob')"
                                style="width: 10em"/>
                    </std-form-group>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <std-form-group
                                label="Phone/Cell"
                                label-for="phone"
                                :errors="form_errors.phone"
                        >
                            <fld-input name="phone" v-model="form_data.phone"/>
                        </std-form-group>
                    </div>
                </div>

                <div class="row">
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
                                <!--<fld-date-->
                                <!--name="license_expiration_date"-->
                                <!--v-model="form_data.license_expiration_date"-->
                                <!--/>-->
                                <flat-pickr
                                        v-model="form_data.license_expiration_date"
                                        @blur="parseDate($event, 'license_expiration_date')"
                                        :config="config"
                                        style="width: 10em"/>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <std-form-group label="City" label-for="city" :errors="form_errors.city">
                                        <fld-input
                                                name="city"
                                                v-model="form_data.city"
                                        />
                                    </std-form-group>
                                </div>
                                <div class="col-md-2">
                                    <std-form-group label="State" label-for="state" :errors="form_errors.state">
                                        <fld-state
                                                name="state"
                                                v-model="form_data.state"
                                        />
                                    </std-form-group>
                                </div>
                                <div class="col-md-4">
                                    <std-form-group label="Zip" label-for="zip" :errors="form_errors.zip">
                                        <fld-input
                                                name="zip"
                                                v-model="form_data.zip"
                                        />
                                    </std-form-group>
                                </div>
                            </div>
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

                <fieldset>
                    <legend>Previous Expungements</legend>


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


                    <div class="col-md-12">
                        <std-form-group
                                label="Previous Felony Expungements"
                                label-for="previous_felony_expungements"
                                :errors="form_errors.previous_felony_expungements"
                        >
                            <fld-input style="width: 3em"
                                       name="previous_felony_expungements"
                                       v-model="form_data.previous_felony_expungements"
                            />
                        </std-form-group>
                    </div>

                    <div class="col-md-12">
                        <std-form-group
                                label="Previous Misdemeanor Expungements"
                                label-for="previous_misdemeanor_expungements"
                                :errors="form_errors.previous_misdemeanor_expungements"
                        >
                            <fld-input style="width: 3em"
                                       name="previous_misdemeanor_expungements"
                                       v-model="form_data.previous_misdemeanor_expungements"
                            />
                        </std-form-group>
                    </div>


                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <h1>paul</h1>
                <std-form-group
                        label="Status"
                        label-for="status"
                        :errors="form_errors.status"
                        :required="true"
                >

                    <ui-select-pick-one
                            url="/api-status/options"
                            v-model="form_data.status_id"
                            :selected_id="form_data.status_id"
                            name="status"
                            blank_value="0"
                            additional_classes="mb-2 grid-filter"
                            styleAttr="max-width: 175px;"
                            required/>

                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                        label="Notes"
                        label-for="notes"
                        :errors="form_errors.notes"
                >
                    <fld-text-area name="notes" v-model="form_data.notes" rows="5"/>
                </std-form-group>
            </div>
            <div class="col-md-12">
                <std-form-group
                        label="Reason for Change"
                        label-for="reason_for_change"
                        :errors="form_errors.reason_for_change"
                >
                    <fld-text-area
                            name="reason_for_change"
                            v-model="form_data.reason_for_change"
                            required
                            rows="5"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="form-group mt-4">
            <div class="row">
                <div class="col-md-4 text-md-left mt-2 mt-md-0">
                    <button class="btn btn-secondary" @click.prevent="cancel">Cancel</button>
                </div>
                <div class="col-md-4 text-center mt-2 mt-md-0" v-if="form_data.id > 0">
                    <button class="btn btn-danger" @click.prevent="deleteRecord">Delete</button>
                </div>
                <div class="col-md-4 text-md-right">
                    <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="processing"
                    >
                        Save
                    </button>
                </div>
            </div>
        </div>


    </form>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        name: "applicant-form",
        components: {
            flatPickr
        },
        props: {
            record: {
                type: [Boolean, Object],
                default: false
            },
            csrf_token: {
                type: String,
                default: ""
            },
            config: {
                type: Object,
                default: function () {
                    return {
                        altInput: true,
                        altFormat: "m/d/Y",
                        dateFormat: "Y-m-d",
                        allowInput: true,
                    }
                },
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
                    address_line_1: "",
                    address_line_2: "",
                    city: "",
                    state: "",
                    zip_code: "",
                    license_number: "",
                    license_issuing_state: "",
                    previous_expungements: "",
                    previous_felony_expungements: 0,
                    previous_misdemeanor_expungements: 0,
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
                    address_line_1: false,
                    address_line_2: false,
                    city: false,
                    state: false,
                    zip_code: false,
                    license_number: false,
                    license_issuing_state: false,
                    previous_expungements: false,
                    previous_felony_expungements: false,
                    previous_misdemeanor_expungements: false,
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
                processing: false
            };
        },
        mounted() {
            if (this.record !== false) {
                // this.form_data._method = 'patch';
                Object.keys(this.record).forEach(i =>
                    this.$set(this.form_data, i, this.record[i])
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
                            // if saved set the get the id back and set to instance
                            if (res.data.form_data) {
                                /// set id in applicant this is a new entry
                                $this.form_data.id = res.data.form_data.id
                                /// reset reason for change
                                $this.form_data.reason_for_change = ''
                                /// recopy the new form_data to our backup
                                for (let index in $this.form_data) {
                                    $this.backup_copy[index] = $this.form_data[index]
                                }

                            }

                            $this.processing = false;
                            this.$emit('input', $this.form_data);      // emit the changed form_data to v-model
                            $this.$bus.$emit('minimize-applicant', $this.form_data.id)
                        } else {
                            this.server_message = res.status;
                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            if (error.response.status === 422) {
                                // Clear errors out
                                Object.keys(this.form_errors).forEach(i =>
                                    this.$set(this.form_errors, i, false)
                                );
                                // Set current errors
                                Object.keys(error.response.data.errors).forEach(i =>
                                    this.$set(
                                        this.form_errors,
                                        i,
                                        error.response.data.errors[i]
                                    )
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
            },
            deleteRecord() {
                let $this = this
                if (confirm('Do you want to delete record?')) {
                    axios.delete(`/applicant/${this.form_data.id}`)
                        .then(response => {
                            console.log(response)
                            // send delete event to Charges List
                            window.location.href = '/applicant'
                        })
                        .catch(error => {
                            console.log(error)
                        })
                }
            },
            cancel() {
                if (this.form_data.id !== 0) {
                    this.form_data.reason_for_change = ''
                    for (let index in this.backup_copy) {
                        this.form_data[index] = this.backup_copy[index]
                    }
                }
                window.location.href = '/applicant';
            },
            parseDate(e, field) {
                this.form_data[field] = this.moment(e, 'MM-DD-YYYY').format('YYYY-MM-DD')
            }
        }
    };
</script>
