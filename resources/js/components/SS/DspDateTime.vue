/**

<dsp-date-time v-model="PostData.created_on"/>

*/

<template>
    <span v-html="display_date"> </span>
</template>

<script>
    import moment from "moment";

    export default {
        name: "dsp-date-time",
        props: {
            value: {
                default: null
            },

        },
        computed: {
            display_date: function () {
                if (this.value) {
                    return moment(String(this.value)).format("MM/DD/YYYY h:mm:ss a");
                } else {
                    return "";
                }
            }
        }
    };
</script>
