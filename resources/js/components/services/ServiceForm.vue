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
            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-12">
                        <std-form-group
                                label="Service Type"
                                label-for="service_type_id"
                                :errors="form_errors.service_type_id"
                        >
                            <ui-select-pick-one
                                    url="/api-service-type/options"
                                    v-model="form_data.service_type_id"
                                    :selected_id="form_data.service_type_id"
                                    name="service_type_id">
                            </ui-select-pick-one>
                        </std-form-group>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
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
                                label="Attn:"
                                label-for="attn"
                                :errors="form_errors.name"
                                :required="true"
                        >
                            <fld-input name="attn" v-model="form_data.attn" required/>
                        </std-form-group>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <std-form-group
                                label="Phone"
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
            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-12">
                        <std-form-group
                                label="Address"
                                label-for="address"
                                :errors="form_errors.address"
                        >
                            <fld-input name="address" v-model="form_data.address"/>
                        </std-form-group>
                    </div>
                </div>

                <div class="row">
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
                </div>

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

                <div class="row">
                    <div class="col-md-12">
                        <std-form-group
                                label="County"
                                label-for="county"
                                :errors="form_errors.county"
                        >
                            <fld-input name="county" v-model="form_data.county"/>
                        </std-form-group>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                        label="Note"
                        label-for="note"
                        :errors="form_errors.note"
                >
                    <fld-text-editor name="note" v-model="form_data.note"/>
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
                        <span v-if="this.form_data.id">Change service</span>
                        <span v-else="this.form_data.id">Add service</span>
                    </button>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                    <a href="/service" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import axios from "axios";
    import UiSelectPickOne from "../SS/UiSelectPickOne";

    export default {
        name: "service-form",
        components: {UiSelectPickOne},
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
                    address: "",
                    address_line_2: "",
                    city: "",
                    state: "",
                    zip: "",
                    county: "",
                    phone: "",
                    email: "",
                    note: "",
                    service_type_id: 0,
                    deleted_at: ""
                },
                form_errors: {
                    id: false,
                    name: false,
                    address: false,
                    address_line_2: false,
                    city: false,
                    state: false,
                    zip: false,
                    county: false,
                    phone: false,
                    email: false,
                    note: false,
                    service_type_id: false,
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
                    url = "/service/" + this.form_data.id;
                    amethod = "put";
                } else {
                    url = "/service";
                    amethod = "post";
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.form_data
                })
                    .then(res => {
                        if (res.status === 200) {
                            window.location = "/service";
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
                                window.location = "/service";
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
