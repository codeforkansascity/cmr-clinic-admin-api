<template>
    <div class="form-group row mb-2 mb-md-0 text-only">
        <label class="col-md-4 col-form-label text-md-right">
            {{ this.params.label }}:
        </label>
        <div class="col-md-8">
            <span class="form-text">
                {{ this.params.value }}
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ui-field-view",
        props: {
            params: {
                type: Object,
                default: function () {
                }
            }
        }
    };
</script>
