/*
<pagination
        :params="{
        current_page: this.params.Page,
        first_page: 1,
        last_page: this.params.Page,
        per_page: this.params.per_page,
        first_row_on_page: this.params.to,
        number_of_rows: this.params.total
    }"
        CATCH
        EMIT
        OF
        PAGE
        TO
        GOTO
></pagination>
*/

<template>
    <div>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "ss-grid"
    };
</script>

<style scoped></style>
