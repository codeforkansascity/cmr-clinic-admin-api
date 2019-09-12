<template>
    <div>
        <div>
            <hr>

            <charge-container
                    v-for="(charge, index) in charges"
                    :key="index"
                    :charge="charge"
            >
            </charge-container>

            <div class="row">
                <div class="col-md-12 pb-5 pt-3">
                    <button class="btn btn-primary btn-sm float-right" @click="addCharge">
                        {{charges.length > 0? 'New Charge': 'Create Charge'}}
                    </button>
                </div>
            </div>
            <hr>
        </div>
    </div>
</template>

<script>
    import ChargeContainer from "./ChargeContainer";
    import DoubleChevronToggle from "../controls/DoubleChevronToggle";

    export default {
        name: "charges-list",
        components: {
            DoubleChevronToggle,
            ChargeContainer},
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
            this.charges = this.data
            this.$bus.$on('charge-deleted:conviction:'+this.conviction_id, (charge_id) => {
                this.removeCharge(charge_id)
            })

        },
        data() {
            return {
                showCharges: false,
                charges: {}
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

                // for(let i in this.charges) {
                //     if(this.charges[i].id === id) {
                //         console.log('deleted '+i)
                //         this.charges.splice(id, 1)
                //     }
                // }
                // we get a warning if we try to use filter
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
