<template>
    <div class="card charge-container">
        <div v-if="view === 'summary'">
            <button class="btn btn-dark" @click="setView('details')">Show Details</button>
            <charge-summary
                :charge="charge"
            ></charge-summary>
        </div>
        <div v-if="view === 'details'">
            <div class="col-md-12">
                <img height="25"
                    src="/img/icons/noun_Pencil_2768160.png"
                    @click="setView('edit')"/>
                <!--<button class="btn btn-dark" @click="setView('edit')">Edit</button>-->

                <button class="btn btn-dark float-right" @click="setView('summary')">Hide Details</button>
            </div>

            <charge-details
                :charge="charge"
            ></charge-details>
        </div>
        <div v-if="view === 'edit'">
            <div class="row" v-if="charge.id != 0">
                <div class="col-md-12">
                    <button class="btn btn-dark float-right" @click="setView('summary')">Hide Details</button>
                </div>
            </div>

            <charge-edit
                :charge="charge"
            ></charge-edit>
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
        },
        created() {
            if(this.charge.id == 0) {
                this.view = 'edit'
            }
        },
        computed: {
        },
    }
</script>

<style scoped>
    .charge-container {
        padding: 15px 5px 15px 5px;
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>
