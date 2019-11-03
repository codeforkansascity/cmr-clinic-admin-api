<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class=" charge-container">
                    <div v-if="view === 'summary'">
                        <!--<button class="btn btn-dark" @click="setView('details')">Show Details</button>-->
                        <applicant-summary v-model="record">
                            <chevron-toggle class="float-right"
                                            :show="false"
                                            @click="setView('details')"/>
                        </applicant-summary>
                    </div>
                    <div v-if="view === 'details'">
                        <applicant-details v-model="record">
                            <chevron-toggle class="float-right"
                                            :show="true"
                                            @click="setView('summary')"/>
                            <pencil-control
                                    height="25"
                                    @click="setView('edit')"/>
                        </applicant-details>
                    </div>
                    <div v-if="view === 'edit'">
                        <applicant-edit v-model="record">
                            <delete-control class="float-right"
                                            height="30"
                                            @click="setView('summary')"/>
                        </applicant-edit>
                    </div>
                    <div class="row" v-if="record.id !== 0">
                        <div class="col-md-12">
                            <!--For now we will keep this one passed as a propery-->
                            <cases-list :data="this.record.conviction"
                                        :applicant_id="this.record.id"></cases-list>
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
            data: {
                type: [Boolean, Object, Array],
                default: () => {
                    return {
                        id: 0,

                    }
                },
            }
        },
        data() {
            return {
                record: {},
                view: 'summary'
            }
        },
        methods: {
            setView(view) {
                this.view = view
            },
        },
        created() {
            Object.keys(this.data).forEach(i =>
                this.$set(this.record, i, this.data[i])
            );
            if (this.record.id === 0) {
                this.view = 'edit'
            }
            this.$bus.$on('minimize-applicant', (id) => {
                if (id === this.record.id) this.setView('summary')
            })
        },
    }
</script>

