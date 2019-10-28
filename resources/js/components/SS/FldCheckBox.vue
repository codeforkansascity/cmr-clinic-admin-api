/**

For checkbox
Example usage:
=====================

<fld-checkbox v-model="form_data.active" required />

<fld-checkbox v-model="row.TrashChecked"/>
<fld-checkbox v-model="form_data.wbe" true-value="yes" false-value="no"/>

*/

<template>

    <input
            type="checkbox"
            :checked="shouldBeChecked"
            :value="value"
            @change="updateInput"
            :name="this.name"
            :id="'field_' + this.name">

</template>

<script>

    // https://www.smashingmagazine.com/2017/08/creating-custom-inputs-vue-js/


    export default {
        name: "fld-checkbox",
        model: {
            prop: 'modelValue',
            event: 'change'
        },
        props: {
            value: {
                type: String,
            },
            modelValue: {
                default: false
            },
            // We set `true-value` and `false-value` to the default true and false so
            // we can always use them instead of checking whether or not they are set.
            // Also can use camelCase here, but hyphen-separating the attribute name
            // when using the component will still work
            trueValue: {
                default: true
            },
            falseValue: {
                default: false
            },
            name: {
                type: String,
                default: ''
            }
        },

        computed: {
            shouldBeChecked() {  // Run only when component is loaded
                // Note that `true-value` and `false-value` are camelCase in the JS
                return this.getBoolean(this.modelValue) === this.getBoolean(this.trueValue)
            }
        },
        methods: {
            updateInput(event) {
                this.$emit('change', event.target.checked ? this.trueValue : this.falseValue)
            }
        }
    }
</script>

