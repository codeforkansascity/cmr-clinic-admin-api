<template>
    <div class="form-group" v-bind:class="getClasses">
        <label :class="'form-control-label ' + this.additionalLabelClasses" :for="this.labelFor != '' ? 'field_' + this.labelFor : false">
            {{ label }}
            <span v-if="this.required === true" class="text-red">(required)</span>
            <a
                href="#"
                v-if="this.$slots.help !== undefined"
                class="form-group-help"
                data-toggle="tooltip"
                v-tooltip="true">
                <img src="/img/icons/help.svg" alt="Help icon - click for help on this field"/>
                <small class="help-text form-text text-muted">
                    <slot name="help"></slot>
                </small>
            </a>
        </label>

        <slot></slot>

        <div class="error-block invalid-feedback" role="alert" v-if="this.errors !== false">
            {{ this.errors[0] }}
        </div>
    </div>
</template>

<script>
export default {
    name: "std-form-group",
    props: {
        label: {
            type: String,
            default: ""
        },
        labelFor: {
            type: String,
            default: ""
        },
        errors: {
            type: [Array, Boolean],
            default: false
        },
        required: {
            type: Boolean,
            default: false
        },
        display: {
            type: String,
            default: "standard"
        },
        additionalLabelClasses: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            has_errors: false,
            showHelp: false,
        };
    },
    computed: {
        getClasses() {
            var classes = '';
            if( this.errors ) {
                classes += 'has-error is-invalid ';
            }
            if(this.display == 'inline') {
                classes += 'form-group-inline ';
            } else {
                classes += 'form-group-standard ';
            }
            return classes;
        }
    }
};
</script>
