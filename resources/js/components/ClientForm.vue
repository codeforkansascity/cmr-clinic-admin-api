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
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Full Name"
                    :errors="form_errors.name"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        v-model="form_data.name"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="Phone" :errors="form_errors.phone">
                    <input
                        type="text"
                        class="form-control"
                        name="phone"
                        v-model="form_data.phone"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="Email" :errors="form_errors.email">
                    <input
                        type="text"
                        class="form-control"
                        name="email"
                        v-model="form_data.email"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="Sex" :errors="form_errors.sex">
                    <input
                        type="text"
                        class="form-control"
                        name="sex"
                        v-model="form_data.sex"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="Race" :errors="form_errors.race">
                    <input
                        type="text"
                        class="form-control"
                        name="race"
                        v-model="form_data.race"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="Dob" :errors="form_errors.dob">
                    <input
                        type="text"
                        class="form-control"
                        name="dob"
                        v-model="form_data.dob"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Address Line 1"
                    :errors="form_errors.address_line_1"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="address_line_1"
                        v-model="form_data.address_line_1"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Address Line 2"
                    :errors="form_errors.address_line_2"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="address_line_2"
                        v-model="form_data.address_line_2"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="City" :errors="form_errors.city">
                    <input
                        type="text"
                        class="form-control"
                        name="city"
                        v-model="form_data.city"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="State" :errors="form_errors.state">
                    <input
                        type="text"
                        class="form-control"
                        name="state"
                        v-model="form_data.state"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="Zip Code" :errors="form_errors.zip_code">
                    <input
                        type="text"
                        class="form-control"
                        name="zip_code"
                        v-model="form_data.zip_code"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="License Number"
                    :errors="form_errors.license_number"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="license_number"
                        v-model="form_data.license_number"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="License Issuing State"
                    :errors="form_errors.license_issuing_state"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="license_issuing_state"
                        v-model="form_data.license_issuing_state"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="License Expiration Date"
                    :errors="form_errors.license_expiration_date"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="license_expiration_date"
                        v-model="form_data.license_expiration_date"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Filing Court"
                    :errors="form_errors.filing_court"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="filing_court"
                        v-model="form_data.filing_court"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Judicial Circuit Number"
                    :errors="form_errors.judicial_circuit_number"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="judicial_circuit_number"
                        v-model="form_data.judicial_circuit_number"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Count Name"
                    :errors="form_errors.count_name"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="count_name"
                        v-model="form_data.count_name"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Judge Name"
                    :errors="form_errors.judge_name"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="judge_name"
                        v-model="form_data.judge_name"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Division Name"
                    :errors="form_errors.division_name"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="division_name"
                        v-model="form_data.division_name"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Petitioner Name"
                    :errors="form_errors.petitioner_name"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="petitioner_name"
                        v-model="form_data.petitioner_name"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Division Number"
                    :errors="form_errors.division_number"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="division_number"
                        v-model="form_data.division_number"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="City Name Here"
                    :errors="form_errors.city_name_here"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="city_name_here"
                        v-model="form_data.city_name_here"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="County Name"
                    :errors="form_errors.county_name"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="county_name"
                        v-model="form_data.county_name"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Arresting County"
                    :errors="form_errors.arresting_county"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="arresting_county"
                        v-model="form_data.arresting_county"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Prosecuting County"
                    :errors="form_errors.prosecuting_county"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="prosecuting_county"
                        v-model="form_data.prosecuting_county"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Arresting Municipality"
                    :errors="form_errors.arresting_municipality"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="arresting_municipality"
                        v-model="form_data.arresting_municipality"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Other Agencies Name"
                    :errors="form_errors.other_agencies_name"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="other_agencies_name"
                        v-model="form_data.other_agencies_name"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Previous Expungements"
                    :errors="form_errors.previous_expungements"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="previous_expungements"
                        v-model="form_data.previous_expungements"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group label="Notes" :errors="form_errors.notes">
                    <input
                        type="text"
                        class="form-control"
                        name="notes"
                        v-model="form_data.notes"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="External Ref"
                    :errors="form_errors.external_ref"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="external_ref"
                        v-model="form_data.external_ref"
                    />
                </std-form-group>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <std-form-group
                    label="Any Pending Cases"
                    :errors="form_errors.any_pending_cases"
                >
                    <input
                        type="text"
                        class="form-control"
                        name="any_pending_cases"
                        v-model="form_data.any_pending_cases"
                    />
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
                        <span v-if="this.form_data.id">Change</span>
                        <span v-else="this.form_data.id">Add</span>
                    </button>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                    <a href="/client" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import axios from "axios";

export default {
    name: "client-form",
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
                dob: "",
                address_line_1: "",
                address_line_2: "",
                city: "",
                state: "",
                zip_code: "",
                license_number: "",
                license_issuing_state: "",
                license_expiration_date: "",
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
                any_pending_cases: ""
            },
            form_errors: {
                id: false,
                name: false,
                phone: false,
                email: false,
                sex: false,
                race: false,
                dob: false,
                address_line_1: false,
                address_line_2: false,
                city: false,
                state: false,
                zip_code: false,
                license_number: false,
                license_issuing_state: false,
                license_expiration_date: false,
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
                any_pending_cases: false
            },
            server_message: false,
            try_logging_in: false,
            processing: false
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
                url = "/client/" + this.form_data.id;
                amethod = "put";
            } else {
                url = "/client";
                amethod = "post";
            }
            await axios({
                method: amethod,
                url: url,
                data: this.form_data
            })
                .then(res => {
                    if (res.status === 200) {
                        window.location = "/client";
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
                            window.location = "/client";
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
