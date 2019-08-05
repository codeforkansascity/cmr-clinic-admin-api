/**

For select specifically for charge-classs
Example usage:
=====================

<fld-charge-class
        name="conviction_class_type"
        v-model="form_data.conviction_class_type"
        required
/>

*/

<template>
    <select
            class="form-control"
            v-model="selected"
            @change="updateValue"
            :name="this.name"
            :id="'field_' + this.name">
        <option v-for="c in charge_classs" v-bind:value="c.abbreviation"> {{ c.name }}</option>
    </select>
</template>

<script>
    export default {
        name: "fld-charge-class",
        model: {
            prop: 'modelValue',
            event: 'change'
        },
        props: {
            modelValue: {
                type: String,
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
                charge_classs: [
                    {
                        "name": "No Class",
                        "abbreviation": ""
                    },
                    {
                        "name": "A",
                        "abbreviation": "A"
                    },
                    {
                        "name": "B",
                        "abbreviation": "B"
                    },
                    {
                        "name": "C",
                        "abbreviation": "C"
                    },
                    {
                        "name": "D",
                        "abbreviation": "D"
                    },
                    {
                        "name": "E",
                        "abbreviation": "E"
                    }

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


