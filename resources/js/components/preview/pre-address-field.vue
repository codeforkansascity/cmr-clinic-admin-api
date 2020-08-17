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
        name: "pre-address-field",
        model: {
            prop: 'modelValue',  // Rename v-model's input value to modelValue
                                 // We will use the default 'input' event for v-model
        },
        props: {
            modelValue: {        // Need to define the v-model input value prop
                type: Object,
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
        data() {
            return {
                record: {}
            }
        },
        created() {
            // Copy v-model's input into a reactive store
            Object.keys(this.modelValue).forEach(i =>
                this.$set(this.record, i, this.modelValue[i])
            );
        },
        computed: {
            val() {
                if (this.record.address_line_1 != '') {
                    if (this.record.address_line_2 != '') {
                        return this.record.address_line_1 + ', ' +
                            this.record.address_line_2 + ', ' +
                            this.record.city + ', ' +
                            this.record.zip_code
                            ;
                    } else {
                        return this.record.address_line_1 + ', ' +
                            this.record.city + ', ' +
                            this.record.zip_code
                            ;
                    }
                } else {
                    return "*** MISSING " + this.missing_prompt + " ***";
                }
            }
        },

    }
</script>

