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
    <span>{{ form_data.value }}</span>
</template>

<script>
    import axios from "axios";

    export default {
        name: "pre-api-field",
        props: {
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
            }
            ,
            defaultValue: {
                type: String,
                default: 'MISSING',
            }
        },
        data: function () {
            return {
                form_data: {
                    // _method: 'patch',
                    id: 0,
                    applicant_id: this.applicantId,
                    petition_number: this.petitionNumber,
                    name: this.field,
                    value: this.defaultValue
                },
            }
        },
        mounted: function () {

            this.getData();

        },
        methods: {
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
            }
        }

    }
</script>

