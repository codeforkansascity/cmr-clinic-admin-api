<template>
    <div style="margin-bottom: 1em">
        <div class="row">

            <div class="col-md-4">
                <h4> {{ record.case_number }}, {{ record.agency }}</h4>
            </div>
            <div class="col-md-5">
                <h4>{{ record.name }}, {{ record.arrest_date }}</h4>
            </div>
            <div class="col-md-2">
                <h4>
                    <dsp-date v-model="record.release_date" />
                </h4>
            </div>

            <div class="col-md-1">
                <slot></slot>
            </div>

            <div class="col-md-12" style="padding-left: 4em;">
                <dsp-textarea v-model="record.notes"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="padding-left: 1em;">
                <table class="table  table-sm">

                    <tr is="tr-view" v-model="record.case_number">Case Number</tr>
                    <tr is="tr-view" v-model="record.court_name">Court</tr>
                    <tr is="tr-view" v-model="record.judge">Judge</tr>
                    <tr is="tr-view" v-model="record.name">Name</tr>


                </table>
            </div>
            <div class="col-md-6" style="padding-left: 1em;">
                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.arrest_date">Arrest date per applicant</tr>
                    <tr is="tr-view" v-model="record.approximate_date_of_charge">Approx charge date</tr>
                    <tr is="tr-view" v-model="record.release_status">Relase Status</tr>
                    <tr is="tr-view-date" v-model="record.release_date">Release Date</tr>
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
            <hr>
            <div class="col-md-5" style="padding-left: 1em;">
                <service-container
                        :services="record.services"
                        :case_id="record.id"
                        @created="createService"
                        @updated="updateService"
                        @deleted="deleteService"
                ></service-container>
            </div>
        </div>
    </div>
</template>


<script>
    import ServiceContainer from "../services/ServiceContainer";

    export default {
        name: "CaseDetails",
        components: {ServiceContainer},
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
        methods: {
            createService(s) {
                this.record.services.push(s)
            },
            updateService(s, i) {
                for (let i in this.record.services) {
                    if (this.record.services[i].id === s.id) {
                        this.record.services[i] = s
                    }
                }
            },
            deleteService(s, i) {
                this.record.services.splice(i, 1)
            }
        },
    }
</script>

<style scoped>

</style>
