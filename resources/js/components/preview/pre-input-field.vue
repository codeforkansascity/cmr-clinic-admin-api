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
    <span>
        <span v-show='toggle'>
            <span>{{ this.val }}</span> <button @click='toggle = !toggle'> Change </button>
        </span>
        <span v-show='!toggle'>
            <input
                :type="this.type"
                :name="this.name"
                ref="input"
                :id="'field_' + this.name"
                class="form-control"
                v-bind:value="value"
                v-on:input="$emit('input', $event.target.value)"
            />
            <a @click='toggle = !toggle'>Cancel</a> <button @click='toggle = !toggle'> Save </button>
        </span>
    </span>

</template>

<script>
    export default {
        name: "pre-field",
        props: {
            'params': {
                type: Object,
                default: function () {
                }
            },
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
            },
            type: {
                type: String,
                default: 'text'
            },
            name: {
                type: String,
                default: ''
            },
        },
        data () {
            return {
                toggle: true
            }
        },
        computed: {
            val() {
                if (this.value != '') {
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

