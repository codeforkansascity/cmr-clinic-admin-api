<template>
    <div class="charge-top" style="margin-bottom: 1em">
        <div class="row">

            <div class="col-md-7">
                <h5 v-if="record.statute">
                    <dsp-statute v-model="record.statute" />
                </h5>
                <h5 v-else>
                    *** {{ record.imported_citation }} {{ record.imported_statute }} ***
                </h5>
            </div>
            <div class="col-md-2">
                <h5>
                    {{ record.conviction_charge_type }} {{ record.conviction_class_type }}
                </h5>
            </div>

            <div class="col-md-2">
                {{ display_charge_eligibility }}
            </div>

            <div class="col-md-1">
                <slot></slot>
            </div>
            <div class="col-md-12" style="padding-left: 8em; padding-right: 8em; padding-bottom: 1.25em;">
                <dsp-textarea v-model="record.notes"></dsp-textarea>
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
                record: {}
            }
        },
        created: function () {
            Object.keys(this.modelValue).forEach(i =>
                this.$set(this.record, i, this.modelValue[i])
            );
        },
        computed: {
            display_charge_eligibility() {
                if ( parseInt(this.record.please_expunge)) {
                    return 'Please Expunge';
                }
                if ( parseInt(this.record.eligible)) {
                    return 'Eligible';
                }
                if ( parseInt(this.record.convicted)) {
                    return 'Convicted';
                }
                return '';
            }
        },
    }
</script>

<style scoped>

</style>
