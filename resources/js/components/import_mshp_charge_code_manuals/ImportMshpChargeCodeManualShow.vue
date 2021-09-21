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
                            Cmr Charge Code Seq
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.cmr_charge_code_seq" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Cmr Charge Code Fingerprintable
                        </label>
                        <div class="col-md-8">
                            <dsp-text
                                v-model="record.cmr_charge_code_fingerprintable"
                            />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Cmr Charge Code Effective Year
                        </label>
                        <div class="col-md-8">
                            <dsp-text
                                v-model="record.cmr_charge_code_effective_year"
                            />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Cmr Charge Code Ncic Category
                        </label>
                        <div class="col-md-8">
                            <dsp-text
                                v-model="record.cmr_charge_code_ncic_category"
                            />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Cmr Charge Code Ncic Modifier
                        </label>
                        <div class="col-md-8">
                            <dsp-text
                                v-model="record.cmr_charge_code_ncic_modifier"
                            />
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
                            Ncic Mod
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.ncic_mod" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            State Mod
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.state_mod" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Description
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.description" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Type Class
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.type_class" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Dna
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.dna" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Sor
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.sor" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Roc
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.roc" />
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
                            Effective Date
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.effective_date" />
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
export default {
    name: "import-mshp-charge-code-manual-show",
    props: {
        record: {
            type: [Boolean, Object],
            default: false
        }
    }
};
</script>
