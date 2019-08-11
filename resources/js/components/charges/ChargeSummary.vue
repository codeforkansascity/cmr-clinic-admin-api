<template>
    <div class="row" style="background-color: lightgoldenrodyellow; margin-top: 1em; ">

        <div class="col-md-6">
            <h5>{{ charge.citation }} {{ charge.charge }} </h5>
        </div>
        <div class="col-md-2">
            <h5>
                {{ charge.conviction_charge_type }} {{ charge.conviction_class_type }}
                <span v-if="charge.notes"> [Note]</span>
            </h5>
        </div>

        <div class="col-md-3">
            {{ is_convicted }} {{ is_eligible}} {{ is_please_expunge }}
        </div>

        <div class="col-md-12" style="padding-left: 4em;">
            {{ charge.notes }}
        </div>

    </div>
</template>

<script>
    export default {
        name: "ChargeSummary",
        props: ['charge'],
        computed: {

            is_convicted() {
                let q = this.charge.convicted;
                return parseInt(q) ? ' -- Convicted' : '';
            },
            is_eligible() {
                let q = this.charge.eligible;
                return parseInt(q) ? ', Eligible' : '';
            },
            is_please_expunge() {
                let q = this.charge.please_expunge;
                return parseInt(q) ? ', PleaseExpunge' : '';
            },
        },
    }
</script>

<style scoped>

</style>
