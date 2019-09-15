<template>
    <div class="row">

        <div class="col-md-7">
            <h5>{{ record.citation }} {{ record.charge }} </h5>
        </div>
        <div class="col-md-2">
            <h5>
                {{ record.conviction_charge_type }} {{ record.conviction_class_type }}
            </h5>
        </div>

        <div class="col-md-2">
            {{ is_convicted }} {{ is_eligible}} {{ is_please_expunge }}
        </div>

        <div class="col-md-1">
            <slot></slot>
        </div>

        <div class="col-md-12" style="padding-left: 4em;">
            {{ record.notes }}
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

            is_convicted() {
                let q = this.record.convicted;
                return parseInt(q) ? ' -- Convicted' : '';
            },
            is_eligible() {
                let q = this.record.eligible;
                return parseInt(q) ? ', Eligible' : '';
            },
            is_please_expunge() {
                let q = this.record.please_expunge;
                return parseInt(q) ? ', PleaseExpunge' : '';
            },
        },
    }
</script>

<style scoped>

</style>
