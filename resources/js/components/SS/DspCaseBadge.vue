<template>
    <div>
        <span v-if="date_is_release_date == true">
            {{ date_name }}<br><span style="font-weight: bolder; font-size: x-large">{{date_from_now}}</span>
        </span>
        <span v-else style="color: gray">
            {{ date_name }}<br><span style="font-weight: bolder; font-size: x-large">{{date_from_now}}</span>
        </span>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        name: "DspCaseBadge",
        props: {
            data: {
                type: [Boolean, Object, Array],
                default: false
            }
        },
        data() {
            return {
                date_is_release_date: false,
                date_name: '',
                date_display: 'No Dates',
                date_from_now: '',
            }
        },
        mounted() {
            if (this.isDefined(this.data.arrest_date)
                && moment(String(this.data.arrest_date)).format('MM/DD/YYYY') != 'Invalid date') {
                this.date_name = 'Arrested';
                this.date_display = moment(String(this.data.arrest_date)).format('MM/DD/YYYY');
                this.date_from_now = moment(String(this.data.arrest_date)).fromNow(true);
            }
            if (this.isDefined(this.data.date_of_charge)
                && moment(String(this.data.date_of_charge)).format('MM/DD/YYYY') != 'Invalid date') {
                this.date_name = 'Charged';
                this.date_display = moment(String(this.data.date_of_charge)).format('MM/DD/YYYY');
                this.date_from_now = moment(String(this.data.date_of_charge)).fromNow(true);
            }
            if (this.isDefined(this.data.date_of_disposition)
                && moment(String(this.data.date_of_disposition)).format('MM/DD/YYYY') != 'Invalid date') {
                this.date_name = 'Disposition';
                this.date_display = moment(String(this.data.date_of_disposition)).format('MM/DD/YYYY');
                this.date_from_now = moment(String(this.data.date_of_disposition)).fromNow(true);
            }
            if (this.isDefined(this.data.release_date)
                && moment(String(this.data.release_date)).format('MM/DD/YYYY') != 'Invalid date') {
                this.date_is_release_date = true;
                this.date_name = 'Released';
                this.date_display = moment(String(this.data.release_date)).format('MM/DD/YYYY');
                this.date_from_now = moment(String(this.data.release_date)).fromNow(true);
            }
        }
    }
</script>

