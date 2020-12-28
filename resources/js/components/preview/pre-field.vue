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
                if ( this.isDefined(this.value)) {
                    if (this.capitalize) {
                        return this.value.toString().toUpperCase();
                    } else {
                        return this.value;
                    }
                } else {
                    return "*** MISSING " + this.missing_prompt + " ***";
                }
            }
        },

    }
</script>

