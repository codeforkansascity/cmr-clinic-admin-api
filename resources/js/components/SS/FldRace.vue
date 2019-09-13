/**

For select specifically for races
Example usage:
=====================

<fld-race
        name="race"
        v-model="form_data.race"
        required
/>

*/

<template>
    <select
            class="form-control"
            v-model="modelValue"
            @change="updateValue"
            :name="this.name"
            :id="'field_' + this.name">
        <option v-for="c in races" v-bind:value="c.abbreviation"> {{ c.name }}</option>
    </select>
</template>

<script>
    export default {
        name: "fld-race",
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
                races: [
                    {
                        "name": "Please select a race or other",
                        "abbreviation": ""
                    },
                    {
                        "name": "White",
                        "abbreviation": "White"
                    },
                    {
                        "name": "Black or African American",
                        "abbreviation": "Black or African American"
                    },
                    {
                        "name": "American Indian or Alaska Native",
                        "abbreviation": "American Indian or Alaska Native"
                    },
                    {
                        "name": "Asian",
                        "abbreviation": "Asian"
                    },
                    {
                        "name": "Hispanic",
                        "abbreviation": "Hispanic"
                    },
                    {
                        "name": "Native Hawaiian or Other Pacific Islander",
                        "abbreviation": "Native Hawaiian or Other Pacific Islander"
                    },
                    {
                        "name": "Other",
                        "abbreviation": "Other"
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


