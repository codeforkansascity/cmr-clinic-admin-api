<template>
    <div>
        <h1 style="color: green;">CHARGE</h1>

        <charge-form v-for="(charge,conviction_index) in records"
                     :key="charge.id"
                     csrf_token="csrf_token"
                     :record="charge">

        </charge-form>
    </div>
</template>

<script>
    export default {
        name: "cases",
        props: {
            records: {
                type: [Boolean, Object],
                default: false
            },
            client_id: {
                type: [Boolean, Number],
                default: 0
            },
            csrf_token: {
                type: String,
                default: ""
            }
        },
    }
</script>

<style scoped>

</style>
