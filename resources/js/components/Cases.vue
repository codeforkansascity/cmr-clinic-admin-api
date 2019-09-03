<template>
    <div style="margin-top: 2em">

        <case-form v-for="(conviction,case_index) in records"
                   :key="conviction.id"
                   :csrf_token="csrf_token"
                   :record="conviction"
                   :client_id="client_id"
                   :case_count="case_index+1">
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
