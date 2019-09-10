<template>
    <div class="row">

        <div class="col-md-6">
            <h4>{{ record.name }}, {{ record.arrest_date }}</h4>
        </div>
        <div class="col-md-3">
            <h4> {{ record.case_number }}, {{ record.agency }}</h4>
        </div>
        <div class="col-md-2">
            <h4>
                {{ record.release_date }}

            </h4>
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
        name: "CaseSummary",
        props: ['record'],
    }
</script>

<style scoped>

</style>
