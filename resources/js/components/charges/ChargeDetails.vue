<template>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Conviction Id
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.conviction_id"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Charge
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.charge"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Citation
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.citation"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Conviction Class Type
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.conviction_class_type"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Conviction Charge Type
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.conviction_charge_type"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Sentence
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.sentence"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Convicted Text
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.convicted_text"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Eligible Text
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.eligible_text"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Please Expunge Text
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.please_expunge_text"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    To Print
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.to_print"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Notes
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.notes"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Convicted
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.convicted"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Eligible
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.eligible"/>
                </div>
            </div>
            <div class="form-group row mb-2 mb-md-0 text-only">
                <label class="col-md-4 col-form-label text-md-right">
                    Please Expunge
                </label>
                <div class="col-md-8">
                    <dsp-text v-model="charge.please_expunge"/>
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
        name: "ChargeDetails",
        props: [
            'charge'
        ],
        data() {
            return {

            }
        }
    }
</script>

<style scoped>

</style>
