/**

For text area
=====================

<dsp-exception v-model="PostData.description"/>


*/

<template>

    <span class="form-text">
        {{ exception.exception_section }}

        [{{ exception.code }}]

        {{ exception.exception_name }}
        <div v-if="exception.exception_note" class="indented-block ml-4">
            {{ exception.exception_note }}
        </div>
        <div v-if="exception.exception_attorney_note" class="indented-block ml-4">
            <span style="color: lightgray;">Atty Instructions:</span> {{ exception.exception_attorney_note }}
        </div>

        <div v-if="exception.exception_dyi_note" class="indented-block ml-4">
            <span style="color: lightgray;">DYI Instructions:</span> {{ exception.exception_dyi_note }}
        </div>

    </span>

</template>

<script>
export default {
    name: 'dsp-exception',
    props: {
        exception: {
            type: [Boolean, Object, Array],
            default: false
        }
    }
}
</script>
