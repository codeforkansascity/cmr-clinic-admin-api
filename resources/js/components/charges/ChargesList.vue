<template>
    <div style="margin-left: 5em">
        <button class="btn btn-primary btn-sm">+ Charge</button>
        <charge-container v-for="(charge, index) in charges"
                     :key="index"
                     :charge="charge">
        </charge-container>
    </div>
</template>

<script>
    import ChargeContainer from "./ChargeContainer";
    export default {
        name: "charges-list",
        components: {ChargeContainer},
        props: {
            charges: {
                type: [Boolean, Object, Array],
                default: false
            }
        },
    }
</script>

<style scoped>

</style>
