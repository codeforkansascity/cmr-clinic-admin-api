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
                    label="Type"
                    label-for="type"
                    :errors="form_errors.jurisdiction_type_id"
                >
                    <v-select label="name"
                              :filterable="false"
                              v-model="selected_jurisdiction_type"
                              :options="jurisdiction_types"
                    >
                    </v-select>
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



        <div class="form-group mt-4">
            <div class="row">
                <div class="col-md-6">
                    <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="processing"
                    >
                        <span v-if="this.form_data.id"
                        >Change jurisdiction</span
                        >
                        <span v-else="this.form_data.id">Add jurisdiction</span>
                    </button>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                    <a href="/jurisdiction" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import axios from "axios";

    export default {
        name: "jurisdiction-form",
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
                    jurisdiction_type_id: 0,
                    name: "",
                },
                form_errors: {
                    id: false,
                    jurisdiction_type_id: false,
                    name: false,
                    url: false,
                    deleted_at: false
                },
                selected_jurisdiction_type: {id: null},
                jurisdiction_types: [],
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
        created() {
            this.getJurisdictionTypes()
        },
        methods: {
            getJurisdictionTypes() {
                axios.get('/api-jurisdiction-type')
                    .then((res) => {
                        this.jurisdiction_types = res.data.data

                        this.selected_jurisdiction_type = this.jurisdiction_types.filter( t => this.form_data.jurisdiction_type_id === t.id)
                    })
                    .catch(e => console.error(e))
            },
            async handleSubmit() {
                this.form_data.jurisdiction_type_id = this.selected_jurisdiction_type.id

                this.server_message = false;
                this.processing = true;
                let url = "";
                let amethod = "";
                if (this.form_data.id) {
                    url = "/jurisdiction/" + this.form_data.id;
                    amethod = "put";
                } else {
                    url = "/jurisdiction";
                    amethod = "post";
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.form_data
                })
                    .then(res => {
                        if (res.status === 200) {
                            window.location = "/jurisdiction";
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
                                window.location = "/jurisdiction";
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
