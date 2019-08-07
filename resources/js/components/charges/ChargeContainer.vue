<template>
    <div class="card">
        <div v-if="view === 'summary'">
            <button @click="setView('details')">See More</button>
            <charge-summary
                :charge="charge"
            ></charge-summary>
        </div>
        <div v-if="view === 'details'">
            <button @click="setView('edit')">Edit</button>
            <charge-details
                :charge="charge"
            ></charge-details>
        </div>
        <div v-if="view === 'edit'">
            <charge-edit
                :charge="charge"
            ></charge-edit>
            <button @click="saveCharge">Save</button>
        </div>
    </div>
</template>

<script>
    import ChargeDetails from "./ChargeDetails";
    import ChargeSummary from "./ChargeSummary";
    import ChargeEdit from "./ChargeEdit";
    export default {
        name: "ChargeContainer",
        components: {ChargeEdit, ChargeSummary, ChargeDetails},
        props: [
            'charge'
        ],
        data() {
            return {
                view: 'summary'
            }
        },
        methods: {
            setView(view) {
                this.view = view
            },
            saveCharge(){
                // TODO axios save charge
            }
        }
    }
</script>

<style scoped>

</style>
