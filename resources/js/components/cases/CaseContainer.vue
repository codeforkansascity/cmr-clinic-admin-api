<template>
    <div class=" charge-container">
        <div v-if="view === 'summary'">
            <!--<button class="btn btn-dark" @click="setView('details')">Show Details</button>-->
            <case-summary :record="record">
                <chevron-toggle class="float-right"
                                :show="false"
                                @click="setView('details')"/>
            </case-summary>
        </div>
        <div v-if="view === 'details'">
            <case-details  :record="record" >
                <chevron-toggle class="float-right"
                                :show="true"
                                @click="setView('summary')"/>
                <pencil-control
                        height="25"
                        @click="setView('edit')"/>
            </case-details>
        </div>
        <div v-if="view === 'edit'">
            <case-edit :record="record">
                <delete-control class="float-right"
                                height="30"
                                @click="setView('summary')"/>
            </case-edit>
        </div>
        <div class="row">
            <div class="col-md-12">
                <charges-list
                        :charges="record.charge"
                        :conviction_id="record.id"
                ></charges-list>
            </div>
        </div>
    </div>
</template>

<script>
    import CaseDetails from "./CaseDetails";
    import CaseSummary from "./CaseSummary";
    import CaseEdit from "./CaseEdit";
    import PencilControl from "../controls/PencilControl";
    import ChevronToggle from "../controls/ChevronToggle";
    import DeleteControl from "../controls/DeleteControl";
    import ChargesList from "../charges/ChargesList";

    export default {
        name: "CaseContainer",
        components: {
            DeleteControl,
            CaseEdit,
            CaseSummary,
            CaseDetails,
            PencilControl,
            ChevronToggle,
            ChargesList
        },
        props: [
            'record'
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
            if (this.record.id == 0) {
                this.view = 'edit'
            }
            this.$bus.$on('minimize-case', (id) => {
                if (id === this.record.id) this.setView('summary')
            })
        },
        computed: {},
    }
</script>

