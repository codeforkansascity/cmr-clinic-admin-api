/**

For text area
=====================

<dsp-text v-model="PostData.description"/>


*/

<template>

        <span class="form-text" v-html="value">

        </span>

</template>

<script>
    export default {
        name: 'dsp-text',
        props: {
            value: {
                default: null
            }
        }
    }
</script>
