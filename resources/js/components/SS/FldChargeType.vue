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
            :value="modelValue"
            @change="updateValue"
            :name="this.name"
            :id="'field_' + this.name">
        <option v-for="c in charge_types"
                v-bind:value="c.abbreviation"
                :selected="c.abbreviation === modelValue"
                :key="c.abbreviation"
        > {{ c.name }}</option>
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
                charge_types: [
                    {
                        "name": "Felony",
                        "abbreviation": "Felony"
                    },
                    {
                        "name": "Misdemeanor",
                        "abbreviation": "Misdemeanor"
                    },
                    {
                        "name": "Infraction",
                        "abbreviation": "Infraction"
                    },
                    {
                        "name": "Ordanace",
                        "abbreviation": "Ordanace"
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


