/**

For text
=====================

<dsp-text
    v-model="PostData.description"
    capitalize="true"
    missing_prompt="What is your full name?"
/>


*/
<template>
            <span>{{ this.val }}</span>
</template>

<script>
    import moment from "moment";

    export default {
        name: "pre-field",
        props: {
            value: {
                default: null
            },
            capitalize: {
                type: [String, Boolean],
                default: false,
            },
            missing_prompt: {
                type: String,
                default: 'MISSING',
            }
        },
        computed: {
            val() {
                if ( this.value != '') {
                        return moment(String(this.value)).format('MMMM Do YYYY');
                } else {
                    return "*** MISSING " + this.missing_prompt + " ***";
                }
            }
        },

    }
</script>

