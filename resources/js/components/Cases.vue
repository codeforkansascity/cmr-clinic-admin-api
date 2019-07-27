<template>
    <div style="margin-left: 5em">
        <h1 style="color: red;">Cases</h1>

        <case-form v-for="(conviction,conviction_index) in records"
                   :key="conviction.id"
                   :csrf_token="csrf_token"
                   :record="conviction"
                   :client_id="client_id">
        </case-form>


    </div>
</template>

<script>
    export default {
        name: "cases",
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
