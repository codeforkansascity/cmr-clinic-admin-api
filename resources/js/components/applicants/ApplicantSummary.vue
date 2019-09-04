<template>
    <div class="row">

        <div class="col-md-11">
            <h4>{{ record.name }}  &nbsp; {{  moment(String(record.dob)).format('MM/DD/YYYY')}}</h4>
        </div>

        <div class="col-md-1">
            <slot></slot>
        </div>

        <div class="col-md-12" style="padding-left: 4em;">
            {{ record.notes }}
        </div>

    </div>
</template>

<script>
    export default {
        name: "ApplicantSummary",
        props: ['record'],
    }
</script>

<style scoped>

</style>
