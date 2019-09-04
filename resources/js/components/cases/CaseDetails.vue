<template>
    <div style="margin-bottom: 1em">
        <div class="row" >

            <div class="col-md-6">
                <h4>{{ record.name }}, {{ record.arrest_date }}</h4>
            </div>
            <div class="col-md-3">
                <h4> {{ record.case_number }}, {{ record.agency }}</h4>
            </div>
            <div class="col-md-2">
                <h4>
                    {{ record.release_date }}

                </h4>
            </div>

            <div class="col-md-1">
                <slot></slot>
            </div>

            <div class="col-md-12" style="padding-left: 4em;">
                {{ record.notes }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Client Id
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.client_id"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Arrest Date
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.arrest_date"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Case Number
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.case_number"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Agency
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.agency"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Court Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.court_name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Court City County
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.court_city_county"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Judge
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.judge"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Record Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.record_name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Release Status
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.release_status"/>
                </div>
            </div>
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
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Approximate Date Of Charge
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.approximate_date_of_charge"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Release Date
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.release_date"/>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        name: "CaseDetails",
        props: [
            'record'
        ],
        data() {
            return {}
        }
    }
</script>

<style scoped>

</style>
