/**

For text area
Example usage:
=====================

<fld-text-editor
    name="description"
    v-model="form_data.description"
    required
/>

*/

<template>

    <textarea
            :name="this.name"
            :id="'field_' + this.name"
            class="form-control"
            v-bind:value="value"
            v-on:input="$emit('input', $event.target.value)">
    </textarea>

</template>

<script>
    export default {
        name: 'fld-text-area',
        props: {
            'params': {
                type: Object,
                default: function () {
                }
            },
            value: {
                default: null
            },
            name: {
                type: String,
                default: ''
            }
        }
    }
</script>
