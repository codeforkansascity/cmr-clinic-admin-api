<template>
    <div>
        <fieldset class="mb-4">
            <legend>General Information</legend>
            <div class="row">
                <div class="col-md-6">

                                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Number                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.number"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Name                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.name"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Common Name                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.common_name"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Jurisdiction Id                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.jurisdiction_id"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Note                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.note"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Statutes Eligibility Id                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.statutes_eligibility_id"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Blocks Time                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.blocks_time"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Same As Id                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.same_as_id"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Superseded Id                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.superseded_id"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Superseded On                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.superseded_on"/>
                    </div>
                </div>
                                        <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Deleted At                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.deleted_at"/>
                    </div>
                </div>
                
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
    export default {
        name: "law-version-show",
        props: {
            record: {
                type: [Boolean, Object],
                default: false,
            },
        },
    };
</script>
