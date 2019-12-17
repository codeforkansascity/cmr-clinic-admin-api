<template>
    <div style="margin-bottom: 1em">
        <div class="row">

            <div class="col-md-11">
                <h4 style="display: inline-block"> {{ record.case_number }}, {{ record.court_city_county }}, {{ record.name }}</h4>
                <span style="float: right">{{ mapNames(record.sources) }}</span>

            </div>

            <div class="col-md-1">
                <slot></slot>
            </div>

            <div class="col-md-12" style="padding-bottom: 1.25em;">
                <dsp-textarea v-model="record.notes"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="padding-left: 1em;">
                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.case_number">Case Number</tr>
                    <tr is="tr-view" v-model="record.name">Case Description</tr>
                    <tr is="tr-view" v-model="record.record_name">Applicant's name in court's records?</tr>
                    <tr is="tr-view" v-model="record.arresting_agency">Arresting Agency</tr>
                    <tr is="tr-view" v-model="record.arrest_date">Date of Arrest</tr>
                    <tr is="tr-view-date" v-model="record.date_of_charge">Date of Charge</tr>
                    <tr is="tr-view" :value="mapNames(record.sources)">Sources</tr>
                </table>
            </div>
            <div class="col-md-6" style="padding-left: 1em;">
                <table class="table  table-sm">
                    <tr is="tr-view" v-model="record.date_of_disposition">Date of Disposition</tr>
                    <tr is="tr-view" v-model="record.release_status">Relase Status</tr>
                    <tr is="tr-view-date" v-model="record.release_date">Release Date</tr>
                    <tr is="tr-view" v-model="record.court_city_county">Court</tr>
                    <tr is="tr-view" v-model="record.judge">Judge</tr>
                    <tr is="tr-view-yn" v-model="record.sis">SIS</tr>
                </table>
            </div>

            <div class="col-md-12" style="padding-left: 1em;">
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
            },
            mapNames(array) {
                if(!array) return ''
                return array.length? array.map(s => s.name).join(', '): ''
            }
        },

    }
</script>

<style scoped>

</style>
