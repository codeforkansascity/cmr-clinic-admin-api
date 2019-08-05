/**

For select specifically for charge-types
Example usage:
=====================

<fld-charge-type
        name="conviction_charge_type"
        v-model="form_data.conviction_charge_type"
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
        <option v-for="c in charge_types" v-bind:value="c.abbreviation"> {{ c.name }}</option>
    </select>
</template>

<script>
    export default {
        name: "fld-charge-type",
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
                charge_types: [
                    {
                        "name": "Felony",
                        "abbreviation": "felony"
                    },
                    {
                        "name": "Misdemeanor",
                        "abbreviation": "misdemeanor"
                    },
                    {
                        "name": "Infraction",
                        "abbreviation": "Infraction"
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


