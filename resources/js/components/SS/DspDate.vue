/**

For text area
=====================

<dsp-date v-model="PostData.created_on"/>


*/

<template>

        <span class="form-text" v-html="moment(String(value)).format('MM/DD/YYYY')">

        </span>

</template>

<script>
    export default {
        name: 'dsp-date',
        props: {
            value: {
                default: null
            }
        }
    }
</script>
