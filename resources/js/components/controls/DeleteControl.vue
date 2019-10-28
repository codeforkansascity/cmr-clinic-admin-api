
<template>
    <div>
        <img :height="height"
             :src="icon"
             @click="toggle"/>
    </div>
</template>

<script>
    export default {
        name: "delete-control",
        props: {

            tooltip: {
                type: String,
                default: 'Delete'
            },
            height: {
                type: Number | String,
                default: 25
            },

        },
        created() {

        },
        data() {
            return {
                icon: "/img/icons/noun_Delete_2768150.png",
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