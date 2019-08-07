<template>
    <div class="card charge-container">
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
        },
        created() {
            if(this.charge.id == 0) {
                this.view = 'edit'
            } else {
                console.log(this.charge.id)
            }
        },
        computed: {
        },
    }
</script>

<style scoped>
    .charge-container {
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>
