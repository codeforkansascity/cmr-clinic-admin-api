<template>
    <div class="row">

        <div class="col-md-11">
            <h4>{{ record.name }}  &nbsp; {{  moment(record.dob,["MM-DD-YYYY", "YYYY-MM-DD"]).format('MM/DD/YYYY')}}</h4>
        </div>

        <div class="col-md-1">
            <slot></slot>
        </div>

        <div class="col-md-12" style="padding-left: 4em;">
            {{ record.notes }}
        </div>

    </div>
</template>

<script>
    export default {
        name: "ApplicantSummary",
        model: {
            prop: 'modelValue',  // Rename v-model's input value to modelValue
                                 // We will use the default 'input' event for v-model
        },
        props: {
            modelValue: {        // Need to define the v-model input value prop
                type: Object,
            },
        },
        data() {
            return {
                record: {

                }
            }
        },
        mounted: function () {
            Object.keys(this.modelValue).forEach(i =>
                this.$set(this.record, i, this.modelValue[i])
            );
        },

    }
</script>

<style scoped>

</style>
