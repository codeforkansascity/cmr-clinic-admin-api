/*
<dsp-boolean v-model="form_data.wbe" true-display="yes" false-display="no"/>
<dsp-boolean v-model="form_data.wbe" true-display="WBE"/>
*/

<template>
    <strong>
        <span v-if="isTrue">{{ trueDisplay }}</span>
        <span v-else>{{ falseDisplay }}</span>
    </strong>
</template>

<script>
    export default {
        name: "dsp-boolean",
        props: {
            value: {
                type: [Boolean, Number, String],
            },
            trueDisplay: {
                type: [Boolean, Number, String],
                default: 'X'
            },
            falseDisplay: {
                type: [Boolean, Number, String],
                default: ''
            },
        },
        computed: {
            isTrue() {
                return this.getBoolean(this.value) == true;
            }
        }
    }
</script>

