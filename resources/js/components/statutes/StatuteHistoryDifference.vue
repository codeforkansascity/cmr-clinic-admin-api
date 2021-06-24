<template>
    <div>
        <a @click.prevent="showDiff = !showDiff" href="">{{showDiff ? "Hide Diff": "Show Diff"}}</a>
        <pre v-if="showDiff">{{value.difference}}</pre>
    </div>
</template>

<script>
export default {
    name: "StatuteHistoryDifference",
    props: {
        value: {
            default: () => ({})
        }
    },
    data() {
        return {
            showDiff: false
        }
    }
}
</script>

<style scoped>

</style>
