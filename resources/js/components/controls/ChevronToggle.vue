<template>
    <div>
        <div>
        <img    v-if="show"
                :height="height"
                :src="trueIcon"
                @click="toggle"/>
        <img    v-if="!show"
                :height="height"
                :src="falseIcon"
                @click="toggle"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "chevron-toggle",
        props: {
            show: {
                type: Boolean,
                default: false,
            },
            tooltip: {
                type: String | Boolean,
                default: false
            },
            height: {
                type: Number,
                default: 30
            },

        },
        created() {

        },
        data() {
            return {

                trueIcon: "/img/icons/noun_chevron_2768158.png",
                falseIcon: "/img/icons/noun_chevron_2768142.png",
            }
        },
        methods: {
            toggle() {
                this.$emit('click')
            }
        }
    }
</script>

<style scoped>

</style>