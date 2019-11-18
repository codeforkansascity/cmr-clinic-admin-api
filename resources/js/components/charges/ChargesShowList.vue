<template>
    <div>
        <charge-show-container
                v-for="(record, index) in charges"
                :key="index"
                :data="record"
        >
        </charge-show-container>
    </div>
</template>

<script>
    import ChargeShowContainer from "./ChargeShowContainer";

    export default {
        name: "charges-show-list",
        components: {
            ChargeShowContainer
        },
        props: {
            data: {
                type: [Boolean, Object, Array],
                default: false
            },
            conviction_id: {
                type: Number,
                default: 0
            }
        },
        created() {
            Object.keys(this.data).forEach(i =>
                this.$set(this.charges, i, this.data[i])
            );
            this.$bus.$on('charge-deleted', (charge_id) => {
                this.removeCharge(charge_id)
            });

        },
        data() {
            return {
                showCharges: false,
                charges: []
            }
        },
        methods: {
            addCharge() {
                let new_charge = {
                    id: 0,
                    conviction_id: this.conviction_id,
                    statute_id: 0,
                    imported_statute: "",
                    imported_citation: "",
                    conviction_class_type: "",
                    conviction_charge_type: "",
                    sentence: "",
                    to_print: "",
                    notes: "",
                    convicted: null,
                    eligible: null,
                    please_expunge: null,
                }
                this.charges.push(new_charge)
                this.showCharges = true
            },
            toggleCharges() {
                this.showCharges = !this.showCharges
            },
            removeCharge(id) {
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
