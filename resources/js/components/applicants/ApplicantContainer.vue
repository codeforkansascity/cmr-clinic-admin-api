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
                    <div class="row" v-if="record.id !== 0">
                        <div class="col-md-12">
                            <cases-list :data="this.record.conviction"
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
                default: () => {
                    return {
                        id: 0,
                        name: null,
                        phone: null,
                        email: null,
                        sex: null,
                        race: null,
                        dob_text: null,
                        address_line_1: null,
                        address_line_2: null,
                        city: null,
                        state: null,
                        zip_code: null,
                        license_number: null,
                        license_issuing_state: null,
                        license_expiration_date_text: null,
                        filing_court: null,
                        judicial_circuit_number: null,
                        count_name: null,
                        judge_name: null,
                        division_name: null,
                        petitioner_name: null,
                        division_number: null,
                        city_name_here: null,
                        county_name: null,
                        arresting_county: null,
                        prosecuting_county: null,
                        arresting_municipality: null,
                        other_agencies_name: null,
                        previous_expungements: null,
                        notes: null,
                        external_ref: null,
                        any_pending_cases: null,
                        deleted_at: null,
                        status_id: null,
                        dob: null,
                        license_expiration_date: null,
                        cms_client_number: null,
                        cms_matter_number: null,
                        assignment_id: null,
                        step_id: null
                    }
                },
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
            /// this fixes reactivity but not sure why
            this.record = Object.assign({}, this.record, this.record)
            if (this.record.id === 0) {
                this.view = 'edit'
            }
            this.$bus.$on('minimize-applicant', (id) => {
                if (id === this.record.id) this.setView('summary')
            })
        },
        computed: {},
    }
</script>

