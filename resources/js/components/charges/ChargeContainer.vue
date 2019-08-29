<template>
    <div class="card charge-container">
        <div v-if="view === 'summary'">
            <div class="row">
                <div class="col-md-12">
                    <chevron-toggle class="float-right"
                                    :show="false"
                                    @click="setView('details')"
                    ></chevron-toggle>
                </div>
            </div>

            <!--<button class="btn btn-dark" @click="setView('details')">Show Details</button>-->
            <charge-summary
                :charge="charge"
            ></charge-summary>
        </div>
        <div v-if="view === 'details'">
            <div class="row">
                <div class="col-md-11"></div>
                <div class="col-md-1">
                    <chevron-toggle class="float-right"
                                    :show="true"
                                    @click="setView('summary')"
                    ></chevron-toggle>
                    <pencil-control
                                    height="25"
                                    @click="setView('edit')">
                    </pencil-control>
                </div>
            </div>

            <charge-details
                    :charge="charge"
            ></charge-details>
        </div>
        <div v-if="view === 'edit'">
            <div class="row" v-if="charge.id != 0">
                <div class="col-md-12">
                    <delete-control class="float-right"
                                    height="30"
                                    @click="setView('summary')">
                    </delete-control>
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
    import PencilControl from "../controls/PencilControl";
    import ChevronToggle from "../controls/ChevronToggle";
    import DeleteControl from "../controls/DeleteControl";

    export default {
        name: "ChargeContainer",
        components: {
            DeleteControl,
            ChargeEdit,
            ChargeSummary,
            ChargeDetails,
            PencilControl,
            ChevronToggle
        },
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
            this.$bus.$on('minimize-charge:charge:'+this.charge.id, () => {
                this.setView('summary')
            })
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
