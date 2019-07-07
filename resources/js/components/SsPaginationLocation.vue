<template>
    <div>
        <div class="mb-2">
            Page {{ current_page }} of {{ last_page }}, {{ total }} Total Results
        </div>
    </div>
</template>

<script>
    export default {
        name: "pagination-location",
        props: {
            current_page: [String, Number],
            last_page: [String, Number],
            total: [String, Number],
        },
    }
</script>

