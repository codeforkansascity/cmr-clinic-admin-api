<template>
    <div class="input-group mb-0" v-bind:class="{'has-error': this.has_errors}">
        <label class="mb-2 mr-2 pt-2 pt-sm-0" for="grid-filter-query-copy">{{ label }}</label>
        <div style="position: relative;">
            <div class="help-block"
                 v-if="this.errors !== false">
                <strong>{{ this.errors[0] }}</strong>
            </div>
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "search-form-group",
        props: {
            label: {
                type: String,
                default: ''
            },
            errors: {
                type: [Array, Boolean],
                default: false
            }
        },
        data() {
            return {
                has_errors: false,
            }
        },
    }
</script>

