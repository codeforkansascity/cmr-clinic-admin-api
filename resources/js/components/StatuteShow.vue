<template>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Number
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.number" />
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
                    Note
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.note" />
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Eligible
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.eligible" />
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Deleted At
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="record.deleted_at" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            test
        </div>
    </div>
</template>

<script>
export default {
    name: "statute-show",
    props: {
        record: {
            type: [Boolean, Object],
            default: false
        }
    }
};
</script>
