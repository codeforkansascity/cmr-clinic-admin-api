/**

For text area
=====================

<dsp-textarea v-model="PostData.description"/>

*/

<template>

        <span class="trim-last-p" v-html="value">

        </span>

</template>

<script>
    export default {
        name: 'dsp-textarea',
        props: {
            value: {
                default: null
            }
        }
    }
</script>
