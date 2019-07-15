<template>
    <div class="form-group" v-bind:class="{ 'has-error': this.errors }">
        <label class="control-label">{{ label }}
            <img src="/img/icons/help.svg" style="margin-left:20px; width:1.5em; height: 1.5em;" v-if="this.$slots.help !== undefined"
                 v-on:click="showHelp = !showHelp"/>
            <transition name="slide-fade">
                <div style="margin-left: 3em; margin-right: 2em; margin-bottom: .5em; margin-top: .5em;"
                     v-if="showHelp && this.$slots.help !== undefined">
                    <slot name="help"></slot>
                </div>
            </transition>

        </label>

        <slot></slot>

        <span class="error-block" v-if="this.errors !== false">
            <strong>{{ this.errors[0] }}</strong>
        </span>
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
        errors: {
            type: [Array, Boolean],
            default: false
        }
    },
    data() {
        return {
            has_errors: false,
            showHelp: false,
        };
    }
};
</script>
