<template>
    <div>
        <fieldset class="mb-4">
            <legend>General Information</legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Section
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.section" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Name
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.name" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Short Name
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.short_name" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Attorney Note
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.attorney_note" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Dyi Note
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.dyi_note" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Logic
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.logic" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Sequence
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.sequence" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Instructions
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.instructions" />
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
export default {
    name: "exception-show",
    props: {
        record: {
            type: [Boolean, Object],
            default: false
        }
    }
};
</script>
