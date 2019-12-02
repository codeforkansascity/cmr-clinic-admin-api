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
        :value="modelValue"
        @change="updateValue"
        :name="this.name"
        :id="'field_' + this.name">
        <option v-for="c in charge_classes"
                v-bind:value="c.abbreviation"
                :selected="c.abbreviation === modelValue"
                :key="c.abbreviation"
        > {{ c.name }}</option>
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
        data() {            return {

                charge_classes: [
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
                    },
                    {
                        "name": "Unclassified",
                        "abbreviation": "U"
                    }

                ]
            }
        },

        mounted: function () {

        },

        methods: {

            updateValue: function (event) {
                this.$emit('change', event.target.value);
            },

        }


    }
</script>


