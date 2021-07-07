<template>
    <form @submit.prevent="handleSubmit" class="form-horizontal">

        <div v-if="server_message !== false" class="alert alert-danger" role="alert">
            {{ this.server_message}}  <a v-if="try_logging_in" href="/login">Login</a>
        </div>

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Number" label-for="number" :errors="form_errors.number">
                        <fld-input
                                name="number"
                                v-model="form_data.number"
                        />
                    </std-form-group>
                </div>
            </div>
        

                    <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Name" label-for="name" :errors="form_errors.name" :required="true">
                        <fld-input
                                name="name"
                                v-model="form_data.name"
                                required
                        />
                        <template slot="help">
                            Name must be unique.
                        </template>
                    </std-form-group>
                </div>
            </div>
                

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Common Name" label-for="common_name" :errors="form_errors.common_name">
                        <fld-input
                                name="common_name"
                                v-model="form_data.common_name"
                        />
                    </std-form-group>
                </div>
            </div>
        

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Jurisdiction Id" label-for="jurisdiction_id" :errors="form_errors.jurisdiction_id">
                        <fld-input
                                name="jurisdiction_id"
                                v-model="form_data.jurisdiction_id"
                        />
                    </std-form-group>
                </div>
            </div>
        

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Note" label-for="note" :errors="form_errors.note">
                        <fld-input
                                name="note"
                                v-model="form_data.note"
                        />
                    </std-form-group>
                </div>
            </div>
        

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Statutes Eligibility Id" label-for="statutes_eligibility_id" :errors="form_errors.statutes_eligibility_id">
                        <fld-input
                                name="statutes_eligibility_id"
                                v-model="form_data.statutes_eligibility_id"
                        />
                    </std-form-group>
                </div>
            </div>
        

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Blocks Time" label-for="blocks_time" :errors="form_errors.blocks_time">
                        <fld-input
                                name="blocks_time"
                                v-model="form_data.blocks_time"
                        />
                    </std-form-group>
                </div>
            </div>
        

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Same As Id" label-for="same_as_id" :errors="form_errors.same_as_id">
                        <fld-input
                                name="same_as_id"
                                v-model="form_data.same_as_id"
                        />
                    </std-form-group>
                </div>
            </div>
        

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Superseded Id" label-for="superseded_id" :errors="form_errors.superseded_id">
                        <fld-input
                                name="superseded_id"
                                v-model="form_data.superseded_id"
                        />
                    </std-form-group>
                </div>
            </div>
        

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Superseded On" label-for="superseded_on" :errors="form_errors.superseded_on">
                        <fld-input
                                name="superseded_on"
                                v-model="form_data.superseded_on"
                        />
                    </std-form-group>
                </div>
            </div>
        

                            <div class="row">
                <div class="col-md-12">
                    <std-form-group label="Deleted At" label-for="deleted_at" :errors="form_errors.deleted_at">
                        <fld-input
                                name="deleted_at"
                                v-model="form_data.deleted_at"
                        />
                    </std-form-group>
                </div>
            </div>
        

        <div class="form-group mt-4">
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary" :disabled="processing">
                        <span v-if="this.form_data.id">Change Law Versions</span>
                        <span v-else="this.form_data.id">Add Law Versions</span>
                    </button>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                    <a href="/law-version" class="btn btn-default">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "law-version-form",
        props: {
            record: {
                type: [Boolean, Object],
                default: false,
            },
            csrf_token: {
                type: String,
                default: ''
            },
        },
        data() {
            return {
                form_data: {
                    // _method: 'patch',
                    _token: this.csrf_token,
                      id: 0,
                                  number: '',
                                name: '',
                                common_name: '',
                                  jurisdiction_id: 0,
                                    note: '',
                            statutes_eligibility_id: 0,
                                blocks_time: 0,
                                same_as_id: 0,
                                superseded_id: 0,
                              superseded_on: '',
                                      deleted_at: '',
                  },
                form_errors: {
                id: false,
                number: false,
                name: false,
                common_name: false,
                jurisdiction_id: false,
                note: false,
                statutes_eligibility_id: false,
                blocks_time: false,
                same_as_id: false,
                superseded_id: false,
                superseded_on: false,
                deleted_at: false,
                },
                server_message: false,
                try_logging_in: false,
                processing: false,
            }
        },
        mounted() {
            if (this.record !== false) {
                // this.form_data._method = 'patch';
                Object.keys(this.record).forEach(
                    i => (this.$set(this.form_data, i, this.record[i]))
                )
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
                    url = '/law-version/' + this.form_data.id;
                    amethod = 'put';
                } else {
                    url = '/law-version';
                    amethod = 'post';
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.form_data
                })
                    .then((res) => {
                        if (res.status === 200) {
                            window.location = '/law-version';
                        } else {
                            this.server_message = res.status;
                        }
                    }).catch(error => {
                        if (error.response) {
                            if (error.response.status === 422) {
                                // Clear errors out
                                Object.keys(this.form_errors).forEach(
                                    i => (this.$set(this.form_errors, i, false))
                                );
                                // Set current errors
                                Object.keys(error.response.data.errors).forEach(
                                    i => (this.$set(this.form_errors, i, error.response.data.errors[i]))
                                );
                            } else  if (error.response.status === 404) {  // Record not found
                                this.server_message = 'Record not found';
                                window.location = '/law-version';
                            } else  if (error.response.status === 419) {  // Unknown status
                                this.server_message = 'Unknown Status, please try to ';
                                this.try_logging_in = true;
                            } else  if (error.response.status === 500) {  // Unknown status
                                this.server_message = 'Server Error, please try to ';
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
        },
    }
</script>

