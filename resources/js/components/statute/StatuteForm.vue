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
            <div class="col-md-2">
                <std-form-group
                        label="Number"
                        label-for="number"
                        :errors="form_errors.number"
                >
                    <fld-input name="number" v-model="form_data.number"/>
                </std-form-group>
            </div>

            <div class="col-md-10">
                <std-form-group
                        label="Name"
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                        label="Note"
                        label-for="note"
                        :errors="form_errors.note"
                >

                    <fld-text-editor
                            name="note"
                            v-model="form_data.note"
                    />

                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                        label="Eligible"
                        label-for="eligible"
                        :errors="form_errors.eligible"
                        :required="true"
                >

                    <ui-select-pick-one
                            url="/api-statutes-eligibility/options"
                            v-model="form_data.statutes_eligibility_id"
                            :selected_id="form_data.statutes_eligibility_id"
                            name="statutes_eligibility"
                            blank_value="0"
                            additional_classes="mb-2 grid-filter"
                            styleAttr="max-width: 175px;"
                            required/>

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
                    <a href="/statute" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import axios from "axios";
    import UiSelectPickOne from "../SS/UiSelectPickOne";

    export default {
        name: "statute-form",
        components: {
            UiSelectPickOne
        },
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
                    number: "",
                    name: "",
                    note: "",
                    statutes_eligibility_id: "",
                    deleted_at: ""
                },
                form_errors: {
                    id: false,
                    number: false,
                    name: false,
                    note: false,
                    statutes_eligibility_id: false,
                    deleted_at: false
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
                    url = "/statute/" + this.form_data.id;
                    amethod = "put";
                } else {
                    url = "/statute";
                    amethod = "post";
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.form_data
                })
                    .then(res => {
                        if (res.status === 200) {
                            window.location = "/statute";
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
                                window.location = "/statute";
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
