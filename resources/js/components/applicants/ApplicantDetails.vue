<template>
    <div style="margin-bottom: 1em">
        <div class="row">

            <div class="col-md-11">
                <h4>{{ record.name }} &nbsp; &nbsp; &nbsp; &nbsp; {{ record.dob }}</h4>
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
                    Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Phone
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.phone"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Email
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.email"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Sex
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.sex"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Race
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.race"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Dob Text
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.dob_text"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Address Line 1
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.address_line_1"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Address Line 2
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.address_line_2"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    City
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.city"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    State
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.state"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Zip Code
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.zip_code"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    License Number
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.license_number"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    License Issuing State
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.license_issuing_state"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    License Expiration Date Text
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.license_expiration_date_text"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Filing Court
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.filing_court"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Judicial Circuit Number
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.judicial_circuit_number"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Count Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.count_name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Judge Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.judge_name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Division Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.division_name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Petitioner Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.petitioner_name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Division Number
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.division_number"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    City Name Here
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.city_name_here"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    County Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.county_name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Arresting County
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.arresting_county"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Prosecuting County
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.prosecuting_county"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Arresting Municipality
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.arresting_municipality"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Other Agencies Name
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.other_agencies_name"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Previous Expungements
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.previous_expungements"/>
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
                    External Ref
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.external_ref"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Any Pending Cases
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.any_pending_cases"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Deleted At
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.deleted_at"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Status Id
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.status_id"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Dob
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.dob"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    License Expiration Date
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.license_expiration_date"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Cms Client Number
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.cms_client_number"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Cms Matter Number
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.cms_matter_number"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Assignment Id
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.assignment_id"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Step Id
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.step_id"/>
                </div>
            </div>

        </div>
    </div>
</template>


<script>
    export default {
        name: "ApplicantDetails",
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
