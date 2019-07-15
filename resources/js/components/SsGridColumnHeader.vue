<template>
    <th>
        <a href="#"
           @click.prevent="sortBy()"
           v-bind:class="{active: selected}"
           title="title">
            <slot></slot>
            <span
                    class="arrow"
                    v-bind:class="sortOrder > 0 ? 'asc' : 'dsc'">
            </span>
        </a>
    </th>
</template>

<script>
    export default {
        name: "grid-column-header",
        props: {
            'params': {
                default: function () {
                }
            },
            selectedKey: [String, Number, Boolean],
            title: [String, Number],
        },
        data: function () {
            return {
                sortOrder: this.params.InitialSortOrder,
            }
        },
        computed: {
            selected: function () {
                return this.params.sortField === this.selectedKey;
            }
        },
        methods: {
            sortBy: function () {
                if ( this.sortOrder == 'asc') {
                    this.sortOrder = -1;
                } else {
                    this.sortOrder = (this.sortOrder == 1 ) ? -1 : 1;
                }
                this.getData();
            },

            getData: function (new_page_number) {
                this.$emit("selectedSort", { sortField: this.params.sortField, sortOrder: this.sortOrder})
            },

        }
    }
</script>

<style scoped>

</style>
