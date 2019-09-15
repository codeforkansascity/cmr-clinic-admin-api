/**

For select specifically for eligibles
Example usage:
=====================

<fld-eligible
        name="eligible"
        v-model="form_data.eligible"
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
        <option v-for="c in eligibles"
                v-bind:value="c.value"
                :key="c.value"
        > {{ c.text }}</option>
    </select>
</template>

<script>
    export default {
        name: "fld-eligible",
        model: {
            prop: 'modelValue',
            event: 'change'
        },
        props: {
            modelValue: {
                type: [Number,String],
                default: ''
            },
            name: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                selected: '',
                eligibles: [
                    {
                        value: null,
                        text: 'Set Eligible'
                    },
                    {
                        value: 0,
                        text: 'NOT Eligible'
                    }, {
                        value: 1,
                        text: 'Eligible'
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


