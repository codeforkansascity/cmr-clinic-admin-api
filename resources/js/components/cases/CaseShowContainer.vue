<template>
    <div>
        <div class="row">
            <div class="col-md-1 text-center" style="padding-left: 1em">
                <h4>Case
                    <br>
                    {{ case_count }}
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

                        <case-details v-model="record">

                        </case-details>

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-11">
                <charges-show-list
                        :data="this.record.charge"
                        :conviction_id="this.record.id"
                ></charges-show-list>
            </div>
        </div>
    </div>

</template>

<script>
    import CaseDetails from "./CaseDetails";
    import ChargesShowList from "../charges/ChargesShowList";
    import moment from 'moment';

    export default {
        name: "CaseShowContainer",
        components: {
            CaseDetails,
            ChargesShowList
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
                date_name: '',
                date_display: 'No Date',
                date_from_now: '',
                date_is_release_date: false,

            }
        },
        created() {
            Object.keys(this.data).forEach(i =>
                this.$set(this.record, i, this.data[i])
            );
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

