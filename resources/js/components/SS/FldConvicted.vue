/**

For select specifically for convicteds
Example usage:
=====================

<fld-convicted
        name="convicted"
        v-model="form_data.convicted"
        required
/>

*/

<template>
    <select
            class="form-control"
            :value="modelValue"
            @change="updateValue"
            :name="this.name"
            :id="'field_' + this.name">
        <option v-for="c in convicteds" v-bind:value="c.value"> {{ c.text }}</option>
    </select>
</template>

<script>
    export default {
        name: "fld-convicted",
        model: {
            prop: 'modelValue',
            event: 'change'
        },
        props: {
            modelValue: {
                type: [Number, String],
                default: null
            },
            name: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                selected: '',
                convicteds: [
                    {
                        value: null,
                        text: 'Set Convicted'
                    },
                    {
                        value: 0,
                        text: 'NOT Convicted'
                    }, {
                        value: 1,
                        text: 'Convicted'
                    },
                ]
            }
        },

        mounted: function () {
            this.selected = this.modelValue;
        },

        methods: {

            updateValue: function (event) {
                this.$emit('change', event.target.value);
            },

        }


    }
</script>


