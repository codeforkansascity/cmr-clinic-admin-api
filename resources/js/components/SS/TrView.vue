<template>
    <tr>
    <td style="width: 10em; color: darkgray">
        <slot></slot>
    </td>
    <td>
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
