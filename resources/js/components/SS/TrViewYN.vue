<template>
    <tr>
        <td style="width: 10em; color: darkgray">
            <slot></slot>
        </td>
        <td>
            {{ display_yn }}
        </td>
    </tr>
</template>

<script>
    export default {
        name: "tr-view-yn",
        props: {
            value: {
                default: null
            }
        },
        computed: {
            display_yn: function () {
                if (this.value) {
                    return 'Yes';
                } else {
                    return 'No';
                }
            }
        }
    }
</script>

