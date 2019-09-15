<template>
    <div style="margin-bottom: 1em">
        <div class="row">

            <div class="col-md-6">
                <h4>{{ record.name }}, {{ record.arrest_date }}</h4>
            </div>
            <div class="col-md-3">
                <h4> {{ record.case_number }}, {{ record.agency }}</h4>
            </div>
            <div class="col-md-2">
                <h4>
                    {{ moment(String(record.release_date)).format('MM/DD/YYYY') }}

                </h4>
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

                    <tr is="tr-view" v-model="record.case_number">Case Number</tr>
                    <tr is="tr-view" v-model="record.court_name">Court</tr>
                    <tr is="tr-view" v-model="record.judge">Judge</tr>
                    <tr is="tr-view" v-model="record.approximate_date_of_charge">Approx charte date</tr>
                    <tr is="tr-view" v-model="record.release_status">Relase Status</tr>
                    <tr is="tr-view" v-model="moment(String(record.release_date)).format('MM/DD/YYYY')">Release Date
                    </tr>


                </table>
            </div>
            <div class="col-md-6" style="padding-left: 1em;">
                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.name">Name</tr>
                    <tr is="tr-view" v-model="record.arrest_date">Arrest date per applicant</tr>
                    <tr is="tr-view" v-model="record.record_name">Client's Name<br>as appeares in court records</tr>

                </table>
            </div>
            <hr>
            <div class="col-md-6" style="padding-left: 1em;">
                <h4>Extra stuff</h4>
                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.agency">Agency</tr>
                    <tr is="tr-view" v-model="record.court_city_county">Court City County</tr>
                    <tr is="tr-view" v-model="record.record_name">Client's Name<br>as appeares in court records</tr>

                </table>
            </div>
        </div>
        <div class="col-md-6">


            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Release Date Text
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.release_date_text"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Notes
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.notes"/>
                </div>
            </div>


        </div>
    </div>
</template>


<script>
    export default {
        name: "CaseDetails",
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
