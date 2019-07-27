<template>
    <div>
        <h1 style="color: red;">Cases</h1>

        <conviction-form v-for="(conviction,conviction_index) in records"
                         :key="conviction.id"
                         csrf_token="csrf_token"
                         :record="conviction">

        </conviction-form>


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
