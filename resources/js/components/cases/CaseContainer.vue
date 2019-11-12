<template>
    <div>
        <div class="row">
            <div class="col-md-1 text-center" style="padding-left: 1em">
                <h4>Case
                    <br>
                    {{ case_count }}
                </h4>
            </div>
            <div class="col-md-11">

                <div class=" charge-container">
                    <div v-if="view === 'summary'">
                        <!--<button class="btn btn-dark" @click="setView('details')">Show Details</button>-->
                        <case-summary v-model="record">
                            <chevron-toggle class="float-right"
                                            :show="false"
                                            @click="setView('details')"/>
                        </case-summary>
                    </div>
                    <div v-if="view === 'details'">
                        <case-details v-model="record">
                            <chevron-toggle class="float-right"
                                            :show="true"
                                            @click="setView('summary')"/>
                            <pencil-control
                                    height="25"
                                    @click="setView('edit')"/>
                        </case-details>
                    </div>
                    <div v-if="view === 'edit'">
                        <case-edit v-model="record" @input="update">
                            <delete-control class="float-right"
                                            height="30"
                                            @click="setView('summary')"/>
                        </case-edit>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <charges-list
                                    :data="this.record.charge"
                                    :conviction_id="this.record.id"
                            ></charges-list>
                        </div>
                    </div>
                </div>
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
        props: {
            data: {
                type: [Boolean, Object, Array],
                default: false
            },
            case_count: {
                type: [Boolean, Number],
                default: 1
            }
        },
        data() {
            return {
                record: {},
                view: 'summary',
            }
        },
        methods: {
            setView(view) {
                this.view = view
            },
            update(v) {
                this.$emit('updateCase', this.$vnode.key, v);
            },
            async deleteCase(case_id) {
                this.$bus.$emit('case-deleted-2', case_id)
                this.setView('summary')
            }

        },
        created() {
            Object.keys(this.data).forEach(i =>
                this.$set(this.record, i, this.data[i])
            );
            if (this.record.id == 0) {
                this.view = 'edit'
            };
            this.$bus.$on('minimize-case', (id) => {
                if (id === this.record.id) this.setView('summary')
                // if charge hasn't been saved but is canceled delete
                if (id === 0) {
                    this.$bus.$emit('case-deleted', 0)
                }
            });
            this.$bus.$on('case-deleted', (case_id) => {
                this.deleteCase(case_id);
            });
        },
    }
</script>

