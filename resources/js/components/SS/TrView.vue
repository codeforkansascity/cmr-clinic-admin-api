<template>
    <tr>
    <td style="width: 10em; color: darkgray; padding: 0rem;">
        <slot></slot>
    </td>
    <td style="padding: 0rem;">
        {{ value }}
    </td>
    </tr>
</template>

<script>
    export default {
        name: "tr-view",
        props: {
            value: {
                default: null
            }
        }
    }
</script>

<style scoped>

</style>
