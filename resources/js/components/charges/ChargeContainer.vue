<template>
    <div class=" charge-container">
        <div v-if="view === 'summary'">
            <!--<button class="btn btn-dark" @click="setView('details')">Show Details</button>-->
            <charge-summary :charge="charge">
                <chevron-toggle class="float-right"
                                :show="false"
                                @click="setView('details')"/>
            </charge-summary>
        </div>
        <div v-if="view === 'details'">
            <charge-details  :charge="charge" >
                <chevron-toggle class="float-right"
                                :show="true"
                                @click="setView('summary')"/>
                <pencil-control
                        height="25"
                        @click="setView('edit')"/>
            </charge-details>
        </div>
        <div v-if="view === 'edit'">
            <charge-edit :charge="charge">
                <delete-control class="float-right"
                                height="30"
                                @click="setView('summary')"/>
            </charge-edit>
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
            if (this.charge.id == 0) {
                this.view = 'edit'
            }
            this.$bus.$on('minimize-charge:charge:'+this.charge.id, () => {
                this.setView('summary')
            })
        },
        computed: {},
    }
</script>

