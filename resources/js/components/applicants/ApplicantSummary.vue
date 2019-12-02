<template>
    <div class="row">

        <div class="col-md-11">
            <h4>{{ record.name }} &nbsp; &nbsp; &nbsp; &nbsp;
                <dsp-date v-model="record.dob"/>
                &nbsp; &nbsp; &nbsp; &nbsp;{{ status_name }}
            </h4>
        </div>

        <div class="col-md-1">
            <slot></slot>
        </div>

        <div class="col-md-12" style="padding-bottom: 1.25em;">
            <dsp-textarea v-model="record.notes"></dsp-textarea>
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
                record: {},
                status_name: ''
            }
        },
        created: function () {
            Object.keys(this.modelValue).forEach(i =>
                this.$set(this.record, i, this.modelValue[i])
            );
            if (!this.isUndefinedOrEmpty(this.record.status) && !this.isUndefinedOrEmpty(this.record.status.name)) {
                this.status_name = this.record.status.name;
            }
        }

    }
</script>

<style scoped>

</style>
