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

        <form @submit.prevent="handleSubmit" class="form-horizontal">
            <div class="col-md-6">
                <h4>{{ form_data.name }}, {{ form_data.arrest_date }}</h4>
            </div>
            <div class="col-md-3">
                <h4> {{ form_data.case_number }}, {{ form_data.agency }}</h4>
            </div>
            <div class="col-md-2">
                <h4>
                    {{ form_data.release_date }}

                </h4>
            </div>
            <div class="col-md-1">
                <img v-show="isShowing" style="width: 1.8em; margin-left: .1em" v-on:click="isShowing ^= true"
                     src="/img/icons/noun_collapse_2091048_000000.png" class="help-button d-print-none">
                <img v-show="!isShowing" style="width: 1.5em; margin-bottom: 1em;  margin-left: .1em"
                     v-on:click="isShowing ^= true"
                     src="/img/icons/noun_expand_1211939_000000.png" class="help-button d-print-none">
            </div>

            <div class="col-md-12" v-show="!isShowing" style="padding-left: 4em;">
                {{ form_data.notes }}
            </div>
            <div></div>
            <div v-show="isShowing">
                <div class="col-md-6" style="padding-left: 2em;">


                    <div class="col-md-12">
                        <std-form-group
                                label="What Applicant calls this (or your abreviation)?"
                                label-for="name"
                                :errors="form_errors.name"
                                :required="true"
                        >
                            <fld-input name="name" v-model="form_data.name" required/>
                            <template slot="help">
                                When speaking with the expungie, how they refer to this. "Car 2005".
                                Until someone meets with the expungie, a short but meaningful description.
                            </template>
                        </std-form-group>
                    </div>

                    <div class="col-md-12">
                        <std-form-group
                                label="Approx. date of arrest per Applicant?"
                                label-for="arrest_date"
                                :errors="form_errors.arrest_date"
                                :required="true"
                        >
                            <fld-input name="arrest_date" v-model="form_data.arrest_date"/>
                            <template slot="help">
                                Any format is ok, even just a year.
                            </template>
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                                label="What was the case number?"
                                label-for="case_number"
                                :errors="form_errors.case_number"
                                :required="true"
                        >
                            <fld-input name="case_number" v-model="form_data.case_number"/>
                        </std-form-group>
                    </div>

                    <div class="col-md-12">
                        <std-form-group
                                label="Was the court a Missouri circuit (county) court or a municipal (city) court?"
                                label-for="agency"
                                :errors="form_errors.agency"
                                :required="true"
                        >
                            <fld-input name="agency" v-model="form_data.agency"/>
                        </std-form-group>
                    </div>

                    <div class="col-md-12">
                        <std-form-group
                                label="What was the name of the County or City?"
                                label-for="court_city_county"
                                :errors="form_errors.court_city_county"
                                :required="true"
                        >
                            <fld-input name="court_city_county" v-model="form_data.court_city_county"/>
                        </std-form-group>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="col-md-12">
                        <std-form-group
                                label="What was your name as it appeared on the court’s records?"
                                label-for="record_name"
                                :errors="form_errors.record_name"
                                :required="true"
                        >
                            <fld-input name="record_name" v-model="form_data.record_name"/>
                        </std-form-group>
                    </div>

                    <div class="col-md-12">
                        <std-form-group
                                label="Release Status (not required)"
                                label-for="release_status"
                                :errors="form_errors.release_status"
                                :required="true"
                        >
                            <fld-input name="release_status" v-model="form_data.release_status"/>
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                                label="Date of Charge (Approximate) - any format"
                                label-for="approximate_date_of_charge"
                                :errors="form_errors.approximate_date_of_charge"
                                :required="true"
                        >
                            <fld-input name="approximate_date_of_charge"
                                       v-model="form_data.approximate_date_of_charge"/>
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                                label="Release Date"
                                label-for="release_date"
                                :errors="form_errors.release_date"
                                :required="true"
                        >
                            <fld-input name="release_date" v-model="form_data.release_date"/>
                        </std-form-group>
                    </div>
                    <div class="col-md-12">
                        <std-form-group
                                label="What was the name of the Judge?"
                                label-for="judge"
                                :errors="form_errors.judge"
                                :required="true"
                        >
                            <fld-input name="judge" v-model="form_data.judge"/>
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
                            <fld-text-area name="notes" v-model="form_data.notes"/>
                        </std-form-group>
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
                                <span v-if="this.form_data.id">Change Case</span>
                                <span v-else="this.form_data.id">Add Case</span>
                            </button>
                        </div>
                        <div class="col-md-6 text-md-right mt-2 mt-md-0">
                            <a href="/conviction" class="btn btn-default">Cancel Case</a>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        <div class="row">
            <div class="col-md-12">
                <charges :records="record.charge"
                         :client_id="client_id"
                         :csrf_token="csrf_token"></charges>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "case-form",
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
                    client_id: 0,
                    name: "",
                    arrest_date: "",
                    case_number: "",
                    agency: "",
                    court_name: "",
                    court_city_county: "",
                    judge: "",
                    record_name: "",
                    release_status: "",
                    release_date_text: "",
                    notes: "",
                    approximate_date_of_charge: "",
                    release_date: null
                },
                form_errors: {
                    id: false,
                    client_id: false,
                    name: false,
                    arrest_date: false,
                    case_number: false,
                    agency: false,
                    court_name: false,
                    court_city_county: false,
                    judge: false,
                    record_name: false,
                    release_status: false,
                    release_date_text: false,
                    notes: false,
                    approximate_date_of_charge: false,
                    release_date: false
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
                    url = "/conviction/" + this.form_data.id;
                    amethod = "put";
                } else {
                    url = "/conviction";
                    amethod = "post";
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.form_data
                })
                    .then(res => {
                        if (res.status === 200) {
                            window.location = "/conviction";
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
                                window.location = "/conviction";
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
