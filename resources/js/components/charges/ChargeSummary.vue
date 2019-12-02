<template>
    <div class="row">
        <div class="col-md-7">
            <h5 v-if="display_statute">
                <dsp-statute v-model="record.statute"/>
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

        <div class="col-md-12" style="padding-left: 4em; padding-bottom: 1.25em;">
            <dsp-textarea v-model="record.notes"></dsp-textarea>
        </div>

    </div>
</template>

<script>
    export default {
        name: "ChargeSummary",
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

            display_statute() {
                return !this.isUndefinedOrEmpty(this.record.statute) && !this.isUndefinedOrEmpty(this.record.statute.id);
            },

            display_charge_eligibility() {
                if (parseInt(this.record.please_expunge)) {
                    return 'Please Expunge';
                }
                if (parseInt(this.record.eligible)) {
                    return 'Eligible';
                }
                if (parseInt(this.record.convicted)) {
                    return 'Convicted';
                }
                return '--';
            }
        },
    }
</script>

<style scoped>

</style>
