<template>
    <tr>
        <td style="width: 10em; color: darkgray">
            <slot></slot>
        </td>
        <td>
            {{ display_date }}
        </td>
    </tr>
</template>

<script>
    import moment from 'moment';
    export default {
        name: "tr-view-date",
        props: {
            value: {
                default: null
            }
        },
        computed: {
            display_date: function () {
                if (this.value) {
                    return moment(String(this.value)).format('MM/DD/YYYY');
                } else {
                    return '';
                }
            }
        }
    }
</script>

