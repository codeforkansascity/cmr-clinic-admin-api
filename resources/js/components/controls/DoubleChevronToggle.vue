<template>
    <div>
        <img v-if="show"
             :height="height"
             :src="trueIcon"
             @click="toggle"/>
        <img v-if="!show"
             :height="height"
             :src="falseIcon"
             @click="toggle"/>
    </div>
</template>

<script>
    export default {
        name: "double-chevron-toggle",
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
                trueIcon: "/img/icons/noun_Chevron double Up_2648915.png",
                falseIcon: "/img/icons/noun_Chevron double down_2648933.png"
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