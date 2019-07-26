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
            <div class="col-md-12">
                <std-form-group
                    label="Id"
                    label-for="id"
                    :errors="form_errors.id"
                >
                    <fld-input name="id" v-model="form_data.id" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Conviction Id"
                    label-for="conviction_id"
                    :errors="form_errors.conviction_id"
                >
                    <fld-input
                        name="conviction_id"
                        v-model="form_data.conviction_id"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Charge"
                    label-for="charge"
                    :errors="form_errors.charge"
                >
                    <fld-input name="charge" v-model="form_data.charge" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Citation"
                    label-for="citation"
                    :errors="form_errors.citation"
                >
                    <fld-input name="citation" v-model="form_data.citation" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Conviction Class Type"
                    label-for="conviction_class_type"
                    :errors="form_errors.conviction_class_type"
                >
                    <fld-input
                        name="conviction_class_type"
                        v-model="form_data.conviction_class_type"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Conviction Charge Type"
                    label-for="conviction_charge_type"
                    :errors="form_errors.conviction_charge_type"
                >
                    <fld-input
                        name="conviction_charge_type"
                        v-model="form_data.conviction_charge_type"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Sentence"
                    label-for="sentence"
                    :errors="form_errors.sentence"
                >
                    <fld-input name="sentence" v-model="form_data.sentence" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Convicted Text"
                    label-for="convicted_text"
                    :errors="form_errors.convicted_text"
                >
                    <fld-input
                        name="convicted_text"
                        v-model="form_data.convicted_text"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Eligible Text"
                    label-for="eligible_text"
                    :errors="form_errors.eligible_text"
                >
                    <fld-input
                        name="eligible_text"
                        v-model="form_data.eligible_text"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Please Expunge Text"
                    label-for="please_expunge_text"
                    :errors="form_errors.please_expunge_text"
                >
                    <fld-input
                        name="please_expunge_text"
                        v-model="form_data.please_expunge_text"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="To Print"
                    label-for="to_print"
                    :errors="form_errors.to_print"
                >
                    <fld-input name="to_print" v-model="form_data.to_print" />
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
                    <fld-input name="notes" v-model="form_data.notes" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Convicted"
                    label-for="convicted"
                    :errors="form_errors.convicted"
                >
                    <fld-input name="convicted" v-model="form_data.convicted" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Eligible"
                    label-for="eligible"
                    :errors="form_errors.eligible"
                >
                    <fld-input name="eligible" v-model="form_data.eligible" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Please Expunge"
                    label-for="please_expunge"
                    :errors="form_errors.please_expunge"
                >
                    <fld-input
                        name="please_expunge"
                        v-model="form_data.please_expunge"
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
                    <a href="/charge" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import axios from "axios";

export default {
    name: "charge-form",
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
                conviction_id: 0,
                charge: "",
                citation: "",
                conviction_class_type: "",
                conviction_charge_type: "",
                sentence: "",
                convicted_text: "",
                eligible_text: "",
                please_expunge_text: "",
                to_print: "",
                notes: "",
                convicted: 0,
                eligible: 0,
                please_expunge: 0
            },
            form_errors: {
                id: false,
                conviction_id: false,
                charge: false,
                citation: false,
                conviction_class_type: false,
                conviction_charge_type: false,
                sentence: false,
                convicted_text: false,
                eligible_text: false,
                please_expunge_text: false,
                to_print: false,
                notes: false,
                convicted: false,
                eligible: false,
                please_expunge: false
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
                url = "/charge/" + this.form_data.id;
                amethod = "put";
            } else {
                url = "/charge";
                amethod = "post";
            }
            await axios({
                method: amethod,
                url: url,
                data: this.form_data
            })
                .then(res => {
                    if (res.status === 200) {
                        window.location = "/charge";
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
                            window.location = "/charge";
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
