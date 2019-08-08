<template>
    <div>
        <div class="row" v-if="!showCharges && charges.length > 0">
            <div class="col-md-12 pad-30">
                <button class="btn btn-dark btn-sm float-right" @click="toggleCharges">Show {{charges.length}} Charges</button>
            </div>
        </div>
        <div v-if="showCharges || charges.length === 0">
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm float-right" @click="addCharge">
                        New Charge
                    </button>
                    <button v-if="charges.length > 0"
                            class="btn btn-dark btn-sm float-right" @click="toggleCharges">
                        Hide Charges
                    </button>
                </div>
            </div>
            <charge-container
                    v-for="(charge, index) in charges"
                    :key="index"
                    :charge="charge"
                    @remove-charge="removeCharge"
            >
            </charge-container>
            <hr>
        </div>
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
            conviction_id: {
                type: Number,
                default: 0
            }
        },
        data() {
            return {
                showCharges: false
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
                    convicted: '0',
                    eligible: '0',
                    please_expunge: '0'
                }
                this.charges.push(new_charge)
                this.showCharges = true
            },
            toggleCharges() {
                this.showCharges = !this.showCharges
            },
            removeCharge(id) {
                console.log('remove-charge ' + id)
                this.charges = this.charges.filter(charge => {
                    return charge.id !== id
                })
            }
        },
    }
</script>

<style scoped>
    .pull-right {
        margin: auto;
        float: right;
    }
    .pad-30 {
        padding-bottom: 30px;
    }
</style>
