<template>
    <div style="margin-bottom: 1em">
        <div class="row" >

            <div class="col-md-6">
                <h5>{{ record.citation }} {{ record.charge }} </h5>
            </div>
            <div class="col-md-2">
                <h5>
                    {{ record.conviction_charge_type }} {{ record.conviction_class_type }}
                    <span v-if="record.notes"> [Note]</span>
                </h5>
            </div>

            <div class="col-md-3">
                {{ is_convicted }} {{ is_eligible}} {{ is_please_expunge }}
            </div>

            <div class="col-md-1">
                <slot></slot>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Sentence
                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.sentence"/>
                    </div>
                </div>
                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        To Print
                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.to_print"/>
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
                        Convicted
                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.convicted"/>
                    </div>
                </div>
                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Eligible
                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.eligible"/>
                    </div>
                </div>
                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Please Expunge
                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.please_expunge"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        name: "ChargeDetails",
        model: {
            prop: 'modelValue',  // Rename v-model's input value to modelValue
                                 // We will use the default 'input' event for v-model
        },
        props: {
            modelValue: {        // Need to define the v-model input value prop
                type: Object,
            },
        },
        data() {
            return {
                record: {

                }
            }
        },
        mounted: function () {
            Object.keys(this.modelValue).forEach(i =>
                this.$set(this.record, i, this.modelValue[i])
            );
        },
        computed: {
            is_convicted() {
                return parseInt(this.record.convicted) ? ' -- Convicted' : '';
            },
            is_eligible() {
                return parseInt(this.record.eligible) ? ', Eligible' : '';
            },
            is_please_expunge() {
                return parseInt(this.record.please_expunge) ? ', PleaseExpunge' : '';
            },
        },
    }
</script>

<style scoped>

</style>
