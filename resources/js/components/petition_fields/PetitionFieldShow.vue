<template>
    <div>
        <fieldset class="mb-4">
            <legend>General Information</legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Applicant Id
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.applicant_id" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Petition Number
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.petition_number" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Field Name
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.field_name" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Value
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.value" />
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
export default {
    name: "petition-field-show",
    props: {
        record: {
            type: [Boolean, Object],
            default: false
        }
    }
};
</script>
