/**

For regular text (or email, phone, etc) input
Example usage:
(Note that "text" is default type; only non-text like "url" needs to be specified)
=====================

<fld-input
        name="name"
        v-model="form_data.name"
        required
/>

<fld-input
        type="url"
        name="web_site"
        v-model="form_data.web_site"
/>

*/

<template>

    <input
            :type="this.type"
            :name="this.name"
            ref="input"
            :id="'field_' + this.name"
            class="form-control"
            v-bind:value="value"
            v-on:input="$emit('input', $event.target.value)"
    />

</template>

<script>
    export default {
        name: 'fld-input',
        props: {
            'params': {
                type: Object,
                default: function () {
                }
            },
            value: {
                default: null
            },
            type: {
                type: String,
                default: 'text'
            },
            name: {
                type: String,
                default: ''
            }
        }
    }
</script>

