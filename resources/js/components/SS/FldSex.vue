/**

For select specifically for sexs
Example usage:
=====================

<fld-sex
    name="sex"
    v-model="form_data.sex"
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
        <option v-for="c in sexs" v-bind:value="c.abbreviation"> {{ c.name }}</option>
    </select>
</template>

<script>
    export default {
        name: "fld-sex",
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
                sexs: [
                    {
                        "name": "Please select sex",
                        "abbreviation": ""
                    },
                    {
                        "name": "Female",
                        "abbreviation": "Female"
                    },
                    {
                        "name": "Intersex",
                        "abbreviation": "Intersex"
                    },
                    {
                        "name": "Male",
                        "abbreviation": "Male"
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


