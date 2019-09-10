<template>
    <div>
        <div class="row">
            <div class="col-md-12">

                <div class=" charge-container">
                    <div v-if="view === 'summary'">
                        <!--<button class="btn btn-dark" @click="setView('details')">Show Details</button>-->
                        <applicant-summary :record="record">
                            <chevron-toggle class="float-right"
                                            :show="false"
                                            @click="setView('details')"/>
                        </applicant-summary>
                    </div>
                    <div v-if="view === 'details'">
                        <applicant-details :record="record">
                            <chevron-toggle class="float-right"
                                            :show="true"
                                            @click="setView('summary')"/>
                            <pencil-control
                                    height="25"
                                    @click="setView('edit')"/>
                        </applicant-details>
                    </div>
                    <div v-if="view === 'edit'">
                        <applicant-edit :record="record">
                            <delete-control class="float-right"
                                            height="30"
                                            @click="setView('summary')"/>
                        </applicant-edit>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <cases-list :cases="this.record.conviction"
                                        :client_id="this.record.id"></cases-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import ApplicantDetails from "./ApplicantDetails";
    import ApplicantSummary from "./ApplicantSummary";
    import ApplicantEdit from "./ApplicantEdit";

    import CasesList from "../cases/CasesList";

    import PencilControl from "../controls/PencilControl";
    import ChevronToggle from "../controls/ChevronToggle";
    import DeleteControl from "../controls/DeleteControl";
    import ChargesList from "../charges/ChargesList";

    export default {
        name: "applicant-container",
        components: {
            DeleteControl,
            ApplicantEdit,
            ApplicantSummary,
            ApplicantDetails,

            CasesList,

            PencilControl,
            ChevronToggle,
            ChargesList
        },
        props: {
            record: {
                type: [Boolean, Object, Array],
                default: false
            }
        },
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
            this.$bus.$on('minimize-applicant', (id) => {
                if (id === this.record.id) this.setView('summary')
            })
        },
        computed: {},
    }
</script>

