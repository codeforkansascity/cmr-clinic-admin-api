<template>
    <div>
        <div class="row">

        </div>
        <div class="row" v-if="mode=='select'">
            <div class="col-md-12" v-if="errors.length">
                <h3>Errors</h3>
                <ul>
                    <li v-for="error in errors">{{error}}</li>
                </ul>
            </div>
            <div class="col-md-4">
                <a
                        href="#"
                        @click.default="goToSS"
                        class="btn btn-primary mb-3 mb-sm-2 mr-3"
                >Add by Spread Sheet</a>

            </div>
            <div class="col-md-4">
                <a
                        href="#"
                        @click.default="goToCMS"
                        class="btn btn-primary mb-3 mb-sm-2 mr-3"
                >Add from CMS</a>

            </div>
            <div class="col-md-4">
                <a
                        href="#"
                        @click.default="goToNew"
                        class="btn btn-primary mb-3 mb-sm-2 mr-3"
                >Add Manually</a>
            </div>
        </div>
        <div class="row" v-if="mode=='SS'">
            <div class="col-md-12">
                <std-form-group
                        label="Upload and Process Applicant History"
                >
                    <table class="file-upload-group">
                        <tr v-if="haveHistory">
                            <td colspan="2" class="file-upload-photo">
                                <img :src="applicant_history.url" alt="Vendor applicant_history">
                            </td>
                        </tr>
                        <tr v-if="haveHistory">
                            <td>
                                <input name="name"
                                       required
                                       v-model="applicant_history.name"
                                       v-bind:class="{file_marked_for_deletion: applicant_historys_to_delete}"/>
                            </td>
                            <td>
                                <a title="Remove file" href="#" v-on:click.prevent="delete_applicant_history()">
                                    <img src="/img/icons/noun_trash_2815015.svg"
                                         alt="Remove file" class="file-upload-delete-icon">
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div class="file-upload-group" v-if="!haveHistory || applicant_historys_to_delete">
                        <photo-uploader
                                end-point="/applicant/file-upload"
                                :save-images="SaveDocuments"
                                :display-name="applicant_history_display_name"
                                :multipart="true"
                                :multiple="true"
                                :maxUploads="1"
                                :userDefinedProperties="[{property: 'display_name', required: true}]"
                                @fileCount="newApplicantHistoriesCount"
                                @fileUploaded="fileUploaded">
                            <template v-slot:browse-btn>
                                <span class="vuejs-uploader__btn">Upload Applicant History Spreadsheet</span>
                            </template>
                        </photo-uploader>
                    </div>

                    <div v-if="CountOfNewApplicantHistories">
                        <a
                                href="#"
                                @click.default="uploadAndAdd"
                                class="btn btn-primary mb-3 mb-sm-2 mr-3"
                        >Upload and Add</a>
                    </div>
                </std-form-group>
            </div>
        </div>
        <div class="row" v-if="mode=='SS-Loading'">
            Loading
        </div>

        <div class="row" v-if="mode=='SS-Processing'">
            Processing
        </div>
    </div>
</template>

<script>

    import axios from "axios";

    function resolveAfter2Seconds() {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve('resolved');
            }, 2000);
        });
    }

    export default {
        name: "applicant-add",
        data: function () {
            return {
                mode: 'select',

                applicant_history: {
                    url: ''
                },

                spread_sheet: {
                    local_file_name: ''
                },

                SaveDocuments: 0,
                CountOfNewApplicantHistories: 0,
                applicant_history_display_name: "",
                applicant_historys_to_delete: null,
                event: null,
                errors: [],
                warnings: [],
                ret: [],
            }
        },
        methods: {
            goToSS: function () {
                this.mode = 'SS';
            },
            goToCMS: function () {
                alert('CMS not implemented yet');
            },

            goToNew: function () {
                window.location.href = "/applicant/create";
            },

            uploadAndAdd() {
                this.errors = [];
                this.warnings = [];
                this.SaveDocuments++;

            },

            async fileUploaded(event) {

                this.mode = 'SS-Processing';

                console.log(
                    'fileUploaded'
                );

                this.spread_sheet.local_file_name = event.response.local_file_name;

                await axios({
                    method: 'POST',
                    url: '/applicant/add-from-ss',
                    data: this.spread_sheet
                })
                    .then(res => {
                        if (res.status === 200) {
                            console.log(res.data);
                            this.saved(res.data);

                        } else {
                            this.server_message = res.status;
                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            if (error.response.status === 422) {
                                // Clear errors out

                                console.log(error.response);
                                this.uploadError(error.response.data);

                                this.server_message = 'The given data was invalid. Please correct the fields in red below.';
                            } else if (error.response.status === 404) {
                                // Record not found
                                this.server_message = "Record not found";
                                window.location = "/applicant";
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
                        this.scrollToTop();
                        this.processing = false;
                    });


            },

            saved(data) {
                console.log('saved');
                this.ret = data;

                window.location = "/applicant/" + data.record.id;
            },

            uploadError(data) {
                console.log('saved');
                this.errors = data.errors;
                this.warnings = data.warnings;
                this.mode = 'select';

            },

            getFileData(event) {
                return event;
            },

            newApplicantHistoriesCount(count) {
                this.CountOfNewApplicantHistories = count;
            },
            delete_applicant_history() {

                if (this.isDefined(this.applicant_history.delete)
                    && this.applicant_history.delete === true) {
                    this.$set(this.applicant_history, 'delete', false);
                    this.applicant_historys_to_delete = false;
                } else {
                    this.$set(this.applicant_history, 'delete', true);
                    this.applicant_historys_to_delete = true;
                }
            },


        },
        computed: {
            haveHistory: function () {
                return this.applicant_history && this.applicant_history.url;
            }
        }
    }
</script>

