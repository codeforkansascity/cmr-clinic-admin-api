<template>
    <div>
        <div class="row" v-if="mode=='select'">
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
                        <tr v-if="haveALogo">
                            <td colspan="2" class="file-upload-photo">
                                <img :src="vc_vendor_logo.url" alt="Vendor logo">
                            </td>
                        </tr>
                        <tr v-if="haveALogo">
                            <td>
                                <input name="name"
                                       required
                                       v-model="vc_vendor_logo.name"
                                       v-bind:class="{file_marked_for_deletion: logos_to_delete}" />
                            </td>
                            <td>
                                <a title="Remove file" href="#" v-on:click.prevent="delete_logo()">
                                    <img src="/img/icons/noun_trash_2815015.svg"
                                         alt="Remove file" class="file-upload-delete-icon">
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div class="file-upload-group" v-if="!haveALogo || logos_to_delete">
                        <photo-uploader
                                end-point="/applicant/file-upload"
                                :save-images="SaveDocuments"
                                :display-name="logo_display_name"
                                :multipart="true"
                                :multiple="true"
                                :maxUploads="1"
                                :userDefinedProperties="[{property: 'display_name', required: true}]"
                                @fileCount="newLogosCount"
                                @uploaded="doneUploadingLogos">
                            <template v-slot:browse-btn>
                                <span class="vuejs-uploader__btn">Upload Applicant History Spreadsheet</span>
                            </template>
                        </photo-uploader>
                    </div>

                    <div v-if="CountOfNewLogos">
                        <a
                                href="#"
                                @click.default="uploadAndAdd"
                                class="btn btn-primary mb-3 mb-sm-2 mr-3"
                        >Upload and Add</a>
                    </div>
                </std-form-group>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "applicant-show",
        data: function () {
            return {
                mode: 'select',

                vc_vendor_logo: {
                    url: ''
                },

                SaveDocuments: 0,
                CountOfNewLogos: 0,
                logo_display_name: "",
                logos_to_delete: null,
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
                this.SaveDocuments = 1;
            },

            doneUploadingLogos() {

                alert('done with upload');
                //window.location = "/vc-vendor";
            },
            newLogosCount(count) {
                this.CountOfNewLogos = count;
            },
            delete_logo() {

                if (this.isDefined(this.vc_vendor_logo.delete)
                    && this.vc_vendor_logo.delete === true) {
                    this.$set(this.vc_vendor_logo, 'delete', false);
                    this.logos_to_delete = false;
                } else {
                    this.$set(this.vc_vendor_logo, 'delete', true);
                    this.logos_to_delete = true;
                }
            },



        },
        computed: {
            haveALogo: function () {
                return this.vc_vendor_logo && this.vc_vendor_logo.url;
            }
        }
    }
</script>

