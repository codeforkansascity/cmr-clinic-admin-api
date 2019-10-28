<template>
    <div>
        <fieldset class="mb-4">
            <legend>General Information</legend>
            <div class="row">
                <div class="col-md-6">
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
                            Address
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.address" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Address Line 2
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.address_line_2" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            City
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.city" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            State
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.state" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Zip
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.zip" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            County
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.county" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Phone
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.phone" />
                        </div>
                    </div>
                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Email
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.email" />
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
                            Service Type Id
                        </label>
                        <div class="col-md-8">
                            <dsp-text v-model="record.service_type_id" />
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
            </div>
        </fieldset>
    </div>
</template>

<script>
export default {
    name: "service-show",
    props: {
        record: {
            type: [Boolean, Object],
            default: false
        }
    }
};
</script>
