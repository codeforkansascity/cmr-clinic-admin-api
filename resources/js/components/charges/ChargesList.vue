<template>
    <div style="margin-left: 5em">
        <h3>Charges</h3>
        <div class="row">
            <div class="float-right">
                <button class="btn btn-primary btn-sm float-right" @click="addCharge">+ Charge</button>
            </div>
        </div>
        <charge-container v-for="(charge, index) in charges"
                     :key="index"
                     :charge="charge">
        </charge-container>
    </div>
</template>

<script>
    import ChargeContainer from "./ChargeContainer";
    export default {
        name: "charges-list",
        components: {ChargeContainer},
        props: {
            charges: {
                type: [Boolean, Object, Array],
                default: false
            },
            conviciton_id: {
                type: Number,
                default: 0
            }
        },
        methods: {
            addCharge() {
                let new_charge = {
                    id: 0,
                    conviction_id: this.conviction_id,
                    charge: "",
                    citation: "",
                    conviction_class_type: "",
                    conviction_charge_type: "",
                    sentence: "",
                    convicted_text: "",
                    eligible_text: "",
                    please_expunge_text: "",
                    to_print: "",
                    notes: "",
                    convicted: 0,
                    eligible: 0,
                    please_expunge: 0
                }
                this.charges.unshift(new_charge)
            }
        },
    }
</script>

<style scoped>
    .pull-right {
        margin: auto;
        float: right;
    }
</style>
