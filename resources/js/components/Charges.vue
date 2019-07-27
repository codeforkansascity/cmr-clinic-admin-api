<template>
    <div style="margin-left: 5em">

        <charge-form v-for="(charge,conviction_index) in records"
                     :key="charge.id"
                     csrf_token="csrf_token"
                     :record="charge">

        </charge-form>
    </div>
</template>

<script>
    export default {
        name: "charges",
        props: {
            records: {
                type: [Boolean, Object, Array],
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
