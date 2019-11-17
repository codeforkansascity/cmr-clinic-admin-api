/**

For text area
=====================

<dsp-date v-model="PostData.created_on"/>


*/

<template>

        <span  v-html="display_date">

        </span>

</template>

<script>
    import moment from 'moment';
    export default {

        name: 'dsp-date',
        props: {
            value: {
                default: null
            }
        },
        computed: {
            display_date: function() {
                if (this.value) {
                    return moment(String(this.value)).format('MM/DD/YYYY');
                } else {
                    return '';
                }
            }
        }
    }
</script>
