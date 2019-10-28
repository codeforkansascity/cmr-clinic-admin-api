<template>
    <div class=" charge-container">
            <charge-details v-model="record">

            </charge-details>

    </div>
</template>

<script>
    import ChargeDetails from "./ChargeDetails";


    export default {
        name: "ChargeShowContainer",
        components: {
            ChargeDetails
        },
        props: {
            data: {
                type: [Boolean, Object, Array],
                default: false
            },
        },
        data() {
            return {
                record: {}
            }
        },
        created() {
            Object.keys(this.data).forEach(i =>
                this.$set(this.record, i, this.data[i])
            );
        },
    }
</script>

