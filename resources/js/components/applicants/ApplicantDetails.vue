<template>
    <div style="margin-bottom: 1em">
        <div class="row">

            <div class="col-md-11">
                <h4>{{ record.name }} &nbsp; &nbsp; &nbsp; &nbsp; {{ moment(String(record.dob)).format('MM/DD/YYYY')
                    }}</h4>
            </div>

            <div class="col-md-1">
                <slot></slot>
            </div>

            <div class="col-md-12" style="padding-left: 4em;">
                {{ record.notes }}
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
                    <tr is="tr-view" v-model="moment(String(record.dob)).format('MM/DD/YYYY')">Date of birth?</tr>
                    <tr is="tr-view" v-model="record.judicial_circuit_number">Judicial Circuit Number</tr>
                    <tr is="tr-view" v-model="record.county_name">County Name</tr>
                    <tr is="tr-view" v-model="record.previous_expungements">Previous Expungements</tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="padding-left: 1em;">

                <h5>Driver’s License information</h5>
                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.license_number">License number</tr>
                    <tr is="tr-view" v-model="record.license_issuing_state">Issuing state</tr>
                    <tr is="tr-view" v-model="record.license_expiration_date">Expiration date</tr>
                </table>

            </div>
            <div class="col-md-6" style="padding-left: 1em;">

                <h5>Current Address</h5>
                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.address_line_1">Address Line 1</tr>
                    <tr is="tr-view" v-model="record.address_line_2">Address Line 2</tr>
                    <tr>
                        <td>City/State/Zip</td>
                        <td>
                            {{ record.city }}
                            {{ record.state }}
                            {{ record.zip }}
                        </td>
                    </tr>
                </table>

            </div>


            <div class="row">
                <div class="col-md-6" style="padding-left: 1em;">

                    <h5>CMS</h5>
                    <table class="table  table-sm">
                        <tr is="tr-view" v-model="record.cms_client_number">Client number</tr>
                        <tr is="tr-view" v-model="record.cms_matter_number">Matter number</tr>
                    </table>

                </div>
                <div class="col-md-6" style="padding-left: 1em;">


                </div>
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
                record: {}
            }
        },
        created: function () {
            Object.keys(this.modelValue).forEach(i =>
                this.$set(this.record, i, this.modelValue[i])
            );
        },
    }
</script>

<style scoped>

</style>
