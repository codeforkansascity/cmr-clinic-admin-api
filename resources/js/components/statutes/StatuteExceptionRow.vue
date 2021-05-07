<template>
    <div class="row">
        <div class="col-md-6">
            <std-form-group
                label="Exception"
                label-for="exception_id"
                :errors="row.exception_id">
                <ui-select-pick-one
                    url="/api-exception/options"
                    v-model="row.exception_id"
                    :selected_id="row.exception_id"
                    name="exception_id"
                    :blank_value="0">
                </ui-select-pick-one>
            </std-form-group>
        </div>
        <div class="col-md-6">
            <std-form-group
                label="Exception Note"
                label-for="common_name"
                :errors="row.exception_note"
            >
                <fld-input name="name" v-model="row.exception_note"/>
            </std-form-group>
        </div>
    </div>
</template>

<script>
export default {
    name: "StatuteExceptionRow",
    props: {
        value: {
            default: () => {}
        },
   },
    data() {
        return  {
            row: this.props.value
        }
    },
    methods: {
        update() {

        }
    }
}
</script>

<style scoped>

</style>
