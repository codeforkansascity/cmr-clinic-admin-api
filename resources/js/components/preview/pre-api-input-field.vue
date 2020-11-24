/**

For text
=====================

<pre-api-field
    applicant-id="this.record.id"
    petition-number="1"
    field="case_heading"
    default="16TH CIRCUIT JUDICIAL CIRCUIT, JACKSON COUNTY, MISSOURI"
/>


*/
<template>
    <span>
        <span v-show='toggle'>
            <span>{{ this.val }}</span>
                    <img class="control-icon"
                         :height="25"
                         :src="icon"
                         @click='toggle = !toggle'/>
        </span>
        <span v-show='!toggle'>
            <input
                :type="this.type"
                :name="this.name"
                ref="input"
                :id="'field_' + this.name"
                class="form-control"
                v-model="form_data.value"

            />
            <a @click='toggle = !toggle'>Cancel</a> <button @click="toggleSave"> Save </button>
        </span>
    </span>

</template>

<script>
    import axios from "axios";

    export default {
        name: "pre-api-input-field",
        props: {
            'params': {
                type: Object,
                default: function () {
                }
            },
            value: {
                default: null
            },
            capitalize: {
                type: [String, Boolean],
                default: false,
            },
            applicantId: {
                type: [String, Number],
                default: 0,
            },
            petitionNumber: {
                type: [String, Number],
                default: 0,
            },
            field: {
                type: String,
                default: 'MISSING',
            },
            type: {
                type: String,
                default: 'text'
            },
            name: {
                type: String,
                default: 'MISSING',
            },
            defaultValue: {
                type: String,
                default: 'MISSING',
            }
        },
        data () {
            return {

                form_data: {
                    // _method: 'patch',
                    _token: this.csrf_token,
                    id: 0,
                    applicant_id: this.applicantId,
                    petition_number: this.petitionNumber,
                    name: this.field,
                    value: this.defaultValue
                },
                form_errors: {
                    id: false,
                    applicant_id: false,
                    petition_number: false,
                    name: false,
                    value: false
                },

                fieldvalue: this.defaultValue,
                server_message: false,
                global_error_message: null,
                gridState: "wait",
                toggle: true,
                icon: "/img/icons/noun_Pencil_2768160.png",
            }
        },
        mounted: function () {

            this.getData();

        },
        methods: {
            toggleSave: function() {
                if (!this.toggle) {
                    this.toggle = true;
                    this.handleSubmit();
                }

            },
            getData: function() {
                let getPage = "/api-petition-field-find/" + this.applicantId + '/' + this.petitionNumber + '/' + this.field;
                this.gridState = "wait";
                axios
                    .get(getPage)
                    .then(response => {
                        if (response.status === 200) {
                            this.form_data.value = response.data.data.value;
                            this.form_data.id = response.data.data.id;
                        } else {
                            this.server_message = res.status;
                        }
                        this.gridState = "good";
                    })
                    .catch(error => {
                        if (error.response) {
                            this.gridState = "error";
                            if (error.response.status === 404) {
                                // Record not found
                                this.server_message = "Record not found";
                                this.form_data.value = this.defaultValue
                            } else if (error.response.status === 419) {
                                // Unknown status
                                // this.server_message =
                                //     "Unknown Status, please try to ";
                                // this.try_logging_in = true;
                            } else if (error.response.status === 500) {
                                // Unknown status
                                // this.server_message =
                                //     "Server Error, please try to ";
                                // this.try_logging_in = true;
                            } else {
                                this.server_message =
                                    error.response.data.message;
                            }
                        } else {
                            console.log(error.response);
                            this.server_message = error;
                        }
                    });
            },
            async handleSubmit() {
                this.server_message = false;
                this.processing = true;
                let url = "";
                let amethod = "";
                if (this.form_data.id) {
                    url = "/petition-field/" + this.form_data.id;
                    amethod = "put";
                } else {
                    url = "/petition-field";
                    amethod = "post";
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.form_data
                })
                    .then(res => {
                        if (res.status === 200) {
                            console.log(res.data);
                            this.form_data.id = res.data.data.id;
                            this.form_data.value = res.data.data.value;
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
                                // window.location = "/petition-field";
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
        },

        computed: {
            val() {
                if (this.form_data.value != '') {
                    if (this.capitalize) {
                        return this.form_data.value.toString().toUpperCase();
                    } else {
                        return this.form_data.value;
                    }
                } else {
                    return "*** MISSING " + this.missing_prompt + " ***";
                }
            }
        },

    }
</script>

