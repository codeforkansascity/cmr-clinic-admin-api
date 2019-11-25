<template>
    <div style="margin-bottom: 1em">
        <div class="row">
            <div class="col-md-11">
                <h4>{{ record.name }} &nbsp; &nbsp; &nbsp; &nbsp;
                    <dsp-date v-model="record.dob"/>
                    &nbsp; &nbsp; &nbsp; &nbsp;{{ status_name }}
                </h4>
            </div>
            <div class="col-md-1">
                <slot></slot>
            </div>

            <div class="col-md-12" style="padding-bottom: 1.25em;">
                <dsp-textarea v-model="record.notes"></dsp-textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6" style="padding-left: 1em;">
                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.name">Full Name</tr>
                    <tr is="tr-view" v-model="record.sex">Sex</tr>
                    <tr is="tr-view" v-model="record.race">Race</tr>


                </table>
            </div>
            <div class="col-md-6" style="padding-left: 1em;">
                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.phone">Phone/Cell</tr>
                    <tr is="tr-view" v-model="record.email">Email</tr>
                    <tr is="tr-view-date" v-model="record.dob">Date of birth?</tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="padding-left: 1em;">

                <h5>Driver’s License</h5>

                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.license_number">License number</tr>
                    <tr is="tr-view" v-model="record.license_issuing_state">Issuing state</tr>
                    <tr is="tr-view-date" v-model="record.license_expiration_date">Expiration date</tr>
                </table>

            </div>
            <div class="col-md-6" style="padding-left: 1em;">

                <h5>Current Address</h5>

                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.address_line_1">Address Line 1</tr>
                    <tr is="tr-view" v-model="record.address_line_2">Address Line 2</tr>
                    <tr>
                        <td style="width: 10em; color: darkgray">City/State/Zip</td>
                        <td>
                            {{ record.city }}
                            {{ record.state }}
                            {{ record.zip_code }}
                        </td>
                    </tr>
                </table>

            </div>
            <div class="col-md-6" style="padding-left: 1em;">

                <h5>CMS</h5>

                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.cms_client_number">CMS Client ID</tr>
                    <tr is="tr-view" v-model="record.cms_matter_number">CMS Case ID</tr>
                </table>

            </div>
            <div class="col-md-6" style="padding-left: 1em;">

                <h5>Previous Expungements</h5>

                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.previous_felony_expungements">Felony</tr>
                    <tr is="tr-view" v-model="record.previous_misdemeanor_expungements">Misdemeanor</tr>
                    <tr is="tr-view" v-model="record.previous_expungements">Notes</tr>
                </table>

            </div>
        </div>
    </div>
</template>


<script>
    export default {
        name: "ApplicantDetails",
        model: {
            prop: 'modelValue',  // Rename v-model's input value to modelValue
                                 // We will use the default 'input' event for v-model
        },
        props: {
            modelValue: {        // Need to define the v-model input value prop
                type: Object,
            },
        },
        data() {
            return {
                record: {},
                status_name: ''
            }
        },
        created: function () {
            Object.keys(this.modelValue).forEach(i =>
                this.$set(this.record, i, this.modelValue[i])
            );
            if (this.isDefined(this.record.status.name)) {
                this.status_name = this.record.status.name;
            }
        },
    }
</script>

<style scoped>

</style>
