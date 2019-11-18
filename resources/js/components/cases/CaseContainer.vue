<template>
    <div>
        <div class="row">
            <div class="col-md-1 text-center" style="padding-left: 1em">
                <h4>Case
                </h4>
                <span v-if="date_is_release_date == true">

                    {{ date_name }}<br>{{date_display}}<br>{{date_from_now}}
                </span>
                <span v-else style="color: gray">
                    {{ date_name }}<br>{{date_display}}<br>{{date_from_now}}
                </span>

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
    import moment from 'moment';

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
                date_name: '',
                date_display: 'No Dates',
                date_from_now: '',
                date_is_release_date: false,
            }
        },
        methods: {
            setView(view) {
                this.view = view
            },
            update(v) {
                this.$emit('updateCase', this.$vnode.key, v);
            },
            addNewCharge(v) {
                if (!this.isDefined(this.record.charge)) {
                    this.$set(this.record,'charge',[]);
                }
                this.record.charge.push(v)
            },
            async deleteCase(case_id) {
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
            });
            this.$bus.$on('adding-new-charge', (v) => {
                if (v.conviction_id === this.record.id) this.addNewCharge(v)
            })
        },
        mounted() {
            if (this.isDefined(this.record.arrest_date)
            && moment(String(this.record.arrest_date)).format('MM/DD/YYYY') != 'Invalid date') {
                this.date_name = 'Arrested';
                this.date_display = moment(String(this.record.arrest_date)).format('MM/DD/YYYY');
                this.date_from_now = moment(String(this.record.arrest_date)).fromNow(true);
            }
            if (this.isDefined(this.record.date_of_charge)
                && moment(String(this.record.date_of_charge)).format('MM/DD/YYYY') != 'Invalid date') {
                this.date_name = 'Charged';
                this.date_display = moment(String(this.record.date_of_charge)).format('MM/DD/YYYY');
                this.date_from_now = moment(String(this.record.date_of_charge)).fromNow(true);
            }
            if (this.isDefined(this.record.date_of_disposition)
                && moment(String(this.record.date_of_disposition)).format('MM/DD/YYYY') != 'Invalid date') {
                this.date_name = 'Disposition';
                this.date_display = moment(String(this.record.date_of_disposition)).format('MM/DD/YYYY');
                this.date_from_now = moment(String(this.record.date_of_disposition)).fromNow(true);
            }
            if (this.isDefined(this.record.release_date)
                && moment(String(this.record.release_date)).format('MM/DD/YYYY') != 'Invalid date') {
                this.date_is_release_date = true;
                this.date_name = 'Released';
                this.date_display = moment(String(this.record.release_date)).format('MM/DD/YYYY');
                this.date_from_now = moment(String(this.record.release_date)).fromNow(true);

            }
        }
    }
</script>

