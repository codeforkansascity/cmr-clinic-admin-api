<template>
    <div>
        <fieldset class="mb-4">
            <legend>General Information</legend>
            <div class="row">
                <div class="col-md-6">

                                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Law Version Id                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.law_version_id"/>
                    </div>
                </div>
                
                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
    export default {
        name: "law-show",
        props: {
            record: {
                type: [Boolean, Object],
                default: false,
            },
        },
    };
</script>
