<template>
    <div>
        <img    v-if="show"
                height="30"
                :src="trueIcon"
                @click="toggle"/>
        <img    v-if="!show"
                height="30"
                :src="falseIcon"
                @click="toggle"/>
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

        },
        created() {
            this.trueIcon = this.icons[1]
            this.falseIcon = this.icons[0]
        },
        data() {
            return {
                icons:  [
                    "/img/icons/noun_chevron_2768142.png",
                    "/img/icons/noun_chevron_2768158.png"
                ],
                trueIcon: null,
                falseIcon: null
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