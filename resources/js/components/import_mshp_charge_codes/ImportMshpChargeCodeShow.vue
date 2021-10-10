<template>
    <div>
        <fieldset class="mb-4">
            <legend>General Information</legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Mshp Version Id
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.mshp_version_id" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Cmr Law Number
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.cmr_law_number" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Cmr Chapter
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.cmr_chapter" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Legacy Charge Code
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.legacy_charge_code" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Charge Type
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.charge_type" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Classification
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.classification" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Effective Date
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.effective_date" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Inactive Date
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.inactive_date" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Reportable
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.reportable" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Short Description
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.short_description" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Not Applicable
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.not_applicable" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Attempt
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.attempt" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Accessory
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.accessory" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Conspiracy
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.conspiracy" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Code Category
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.code_category" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Ncic Category
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.ncic_category" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Statute
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.statute" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Long Description
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.long_description" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Uniform Citation Ind
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.uniform_citation_ind" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Rec Of Conviction
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.rec_of_conviction" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Case Type
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.case_type" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Charge Code
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.charge_code" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Dna At Arrest
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.dna_at_arrest" />
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
export default {
    name: "import-mshp-charge-code-show",
    props: {
        record: {
            type: [Boolean, Object],
            default: false
        }
    }
};
</script>
