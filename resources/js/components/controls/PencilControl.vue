<template>
    <div>
        <img class="control-icon"
             :height="height"
             :src="icon"
             @click="toggle"/>
    </div>
</template>

<script>
    export default {
        name: "pencil-control",
        props: {

            tooltip: {
                type: String,
                default: 'Collapse or expand nodes'
            },
            height: {
                type: Number | String,
                default: 30
            },

        },
        created() {

        },
        data() {
            return {
                icon: "/img/icons/noun_Pencil_2768160.png",
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
.control-icon {
    cursor: pointer;
}
</style>
