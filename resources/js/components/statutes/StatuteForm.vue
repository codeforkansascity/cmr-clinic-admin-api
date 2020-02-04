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

            <div class="col-md-4">
                <std-form-group

                    label="Jurisdiction Type"
                    :errors="false"
                >
                    <v-select label="name"
                              :filterable="false"
                              v-model="selected_jurisdiction_type"
                              :options="jurisdiction_types"
                              @input="filterJurisdictionsByType"
                    >
                    </v-select>

                </std-form-group>


            </div>


            <div class="col-md-4">
                <std-form-group
                    label="Jurisdiction"
                    :errors="form_errors.jurisdiction_id"
                >
                    <v-select label="name"
                              class="d-inline-block w-85"
                              :filterable="false"
                              v-model="selected_jurisdiction"
                              :options="jurisdictions"
                    >
                    </v-select>
                    <add-icon
                        @click="$refs.jurisdictionModal.showModal = true"
                        :height="25"
                    />
                </std-form-group>
            </div>
            <jurisdiction-create-modal ref="jurisdictionModal" @add="addJurisdiction"/>


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

        <div class="row pb-3" v-if="selected_jurisdiction_type && selected_jurisdiction_type.name.toLowerCase() !== 'state'">
            <div class="col-md-9">
                <label class="form-control-label">
                    Same As State Statute
                </label>

                <fld-statute
                    v-model="form_data.same_as_id"
                    @input="statuteSelected"
                ></fld-statute>
            </div>

        </div>

        <div class="row pb-3">
            <div class="col-md-9">
                <label class="form-control-label">
                    Superseded By
                </label>

                <fld-statute
                        v-model="form_data.superseded_id"
                        @input="statuteSelected"
                ></fld-statute>
            </div>
            <div class="col-md-3">
                <std-form-group
                        label="Superseded On"
                        label-for="superseded_on"
                        :errors="form_errors.superseded_on"
                >
                    <fld-input name="superseded_on" v-model="form_data.superseded_on"/>
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
    import AddIcon from "../controls/AddIcon";


    export default {
        name: "statute-form",
        components: {
            UiSelectPickOne, AddIcon
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
                selected_jurisdiction_type: null,
                selected_jurisdiction: {id: null},
                jurisdiction_types: [],
                jurisdictions: [],
                all_jurisdictions: [],


                form_data: {
                    // _method: 'patch',
                    _token: this.csrf_token,
                    id: 0,
                    number: "",
                    name: "",
                    note: "",
                    statutes_eligibility_id: "",
                    deleted_at: "",
                    jurisdiction_id: null,
                    same_as_id: null,

                },
                form_errors: {
                    id: false,
                    number: false,
                    name: false,
                    note: false,
                    statutes_eligibility_id: false,
                    deleted_at: false,
                    jurisdiction_id: false,
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
            this.getData()
        },
        methods: {
            getData() {
                this.getJurisdictions()
                this.getJurisdictionTypes()
            },
            async handleSubmit() {

                this.form_data.jurisdiction_id = this.selected_jurisdiction.id
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
            },
            statuteSelected(statute) {
                this.record.superseded_id = null
            },

            filterJurisdictionsByType(e) {
                this.jurisdictions = this.all_jurisdictions.filter(j => {
                    return j.jurisdiction_type_id === e.id
                })

            },

            addJurisdiction(j) {
                if(j && j.id > 0) {
                    this.jurisdictions.push(j)
                    this.form_data.jurisdiction_id = j
                }
            },

            getJurisdictions() {
                axios.get('/api-jurisdiction')
                    .then((res) => {
                        this.all_jurisdictions = res.data.data

                        this.jurisdictions = this.all_jurisdictions

                        this.selected_jurisdiction = this.jurisdictions.filter(j => j.id ===  this.form_data.jurisdiction_id)
                    })
                    .catch(e => console.error(e))
            },

            getJurisdictionTypes() {
                axios.get('/api-jurisdiction-type')
                    .then((res) => {
                        this.jurisdiction_types = res.data.data
                    })
                    .catch(e => console.error(e))
            }
        }
    };
</script>
