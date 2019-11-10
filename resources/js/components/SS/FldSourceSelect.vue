<template>
    <v-select label="name"
              :filterable="false"
              :multiple="true"
              v-model="selected"
              :options="matches"
              @input="update"
    >
    </v-select>
</template>

<script>
    export default {
        name: "FldSourceSelect",
        props: {
            value: {
                type: Array|Object,
                default: null,
            },
        },
        created() {
            this.getData()
            this.selected = this.value
        },
        data() {
            return {
                matches: [],
                selected: [],
            }
        },
        methods: {
            getData() {
                axios.get('/api-data-source')
                    .then(res => {
                        console.log(res)
                        this.matches = res.data.data
                    })
                    .catch(e => {console.error(e)})
            },
            update(v) {
                console.log(v)
                this.selected = v
                this.$emit('input', v)
            },
        }
    }
</script>

<style scoped>

</style>
